<?php
/**
 * Class AjaxController
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2020/12
 * @copyright   Blog do Mario SAM
 * 
 * Responsable to call webservice (using ajax) to get estimate cep values.
 */
namespace MarioSAM\EstimateCep\Controller\Index;

//class AjaxController implements HttpGetActionInterface
class AjaxController extends \Magento\Framework\App\Action\Action
{
    protected $_context;
    protected $_resultFactory;
    protected $_pageFactory;

    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\ResultFactory $resultFactory
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Magento\Framework\Controller\ResultFactory $resultFactory,
            \Magento\Framework\View\Result\PageFactory $pageFactory
    )
    {
            $this->_context = $context;
            $this->_resultFactory = $resultFactory;
            $this->_pageFactory = $pageFactory;

            parent::__construct($context);
    }

    /**
     * Execute start the process of ajax dispath
     * 
     * @return type
     */
    public function execute()
    {
        $result = $this->_resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);

        //verifica se essa classe foi iniciada por uma requisicao ajax
        if ($this->getRequest()->isAjax()) 
        {
            $result->setData( $this->getCorreiosFrete() );
        }

        return $result;
    }

    /**
     * Abre conexao com correios por webservice p/ recuperar valores de frete
     *
     */
    protected function getCorreiosFrete() 
    {
        //url dos correios para calcular preco e prazo
        $webservice = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';

        //inicializa biblioteca curl para chamada do webservice
        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_HEADER, false);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array('Accept: application/xml,text/xml;q=0.9,text/plain;q=0.8'));
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

        //recupera do config quais servicos dos correios devem ser lidos
        $modeValues = explode(',', $this->getRequest()->getParam('cepModes', false));
        //para cada servico uma consulta
        foreach ( $modeValues as $mode ) {
            //prepara os dados de envio e executa curl
            curl_setopt($cURL, CURLOPT_URL, $webservice.'?'.$this->_dadosurl( $mode ));
            $resposta = curl_exec($cURL);

            //se houve falha na comunicacao, encerra por aqui
            if ($resposta === false) return curl_error($cURL);

            //transforma o retorno dos correios em um objeto para leitura
            $resposta = html_entity_decode($resposta);
            $resposta = simplexml_load_string(trim($resposta)); //@simplexml_load_string($resposta);

            //trata e compacta o retorno dos dados para saida js/html
            $retorno[] = $this->_trataRetorno( $resposta->cServico );
        }
        //encerra biblioteca curl
        curl_close($cURL);

        return $retorno;
    }

    /**
     * Monta url com parametros requeridos pelos correios
     *
     */
    protected function _dadosurl( $cdServico='' ) {
        $data['nCdServico'] = $cdServico;
        $data['nCdEmpresa'] = urlencode( $this->getRequest()->getParam('cepEmpresa', false) );
        $data['sDsSenha']   = urlencode( $this->getRequest()->getParam('cepCodigo', false) );
        $data['StrRetorno'] = 'xml';

        $data['sCepDestino'] = preg_replace("([^0-9])",'',urlencode( $this->getRequest()->getParam('cepDestino', false) ));
        $data['sCepOrigem']  = urlencode( $this->getRequest()->getParam('cepOrigem', false) );

        $data['nVlPeso']        = urlencode( $this->getRequest()->getParam('cepPeso', false) ) > 0 ? urlencode( $this->getRequest()->getParam('cepPeso', false) ) : 1;
        $data['nVlComprimento'] = urlencode( $this->getRequest()->getParam('cepComprimento', false) );
        $data['nVlDiametro']    = urlencode( $this->getRequest()->getParam('cepDiametro', false) );
        $data['nVlAltura']      = urlencode( $this->getRequest()->getParam('cepAltura', false) );
        $data['nVlLargura']     = urlencode( $this->getRequest()->getParam('cepLargura', false) );
        $data['nCdFormato']     = urlencode( $this->getRequest()->getParam('cepFormato', false) );

        $data['sCdMaoPropria']       = 'N';
        $data['nVlValorDeclarado']   = 0;
        $data['sCdAvisoRecebimento'] = 'N';

        return http_build_query($data);
    }

    /**
     * Prepara retorno de dados para serem apresentados pela chamada ajax
     *
     */
    protected function _trataRetorno( $obj='' ) {
        //verifica se chegou um objeto valido para ser lido
        if ( $obj == false ) { return __('Wrong XML: Error in simplexml_load_string.'); }

        //array para transformar codigo de consulta em uma saida string (frontend)
        $rotulo = array(
            '04510'=>__('PAC'),
            '41068'=>__('PAC'),
            '41106'=>__('PAC'),
            '04014'=>__('SEDEX'),
            '40010'=>__('SEDEX'),
            '40096'=>__('SEDEX'),
            '40436'=>__('SEDEX'),
            '40444'=>__('SEDEX'),
            '04790'=>__('SEDEX 10'),
            '40215'=>__('SEDEX 10'),
            '04804'=>__('SEDEX Today'),
            '40290'=>__('SEDEX Today'),
            '40045'=>__('SEDEX to Charger'),
            '04782'=>__('SEDEX 12'),
            '81019'=>__('e-SEDEX') );

        //codigo dos correios para indicar que a resposta foi ok
        if ( $obj->Erro == 0 ) {
            //recupera o tipo de consulta (do array de codigos)
            $tipo = strtolower( $rotulo[strval( $obj->Codigo )] );

            //montando o resultado final para devolver ao html
            return array('status'=>200,'tipo'=>strtoupper($tipo),'valor'=>strval($obj->Valor),'prazo'=>strval($obj->PrazoEntrega),'erro'=>strval($obj->Erro),'msg'=>strval($obj->MsgErro));
        } else {
            //se houve fala no codigo de consulta, retorna msg dos correios
            return array('status'=>99,'tipo'=>strtoupper($obj->Codigo),'erro'=>strval($obj->Erro),'msg'=>strval($obj->MsgErro));
        }

        //return $array; //return json_encode( $array );
    }
}
