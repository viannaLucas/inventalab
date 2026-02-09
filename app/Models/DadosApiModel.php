<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class DadosApiModel extends BaseModel{
    
    protected $table = 'DadosApi';
    protected $allowedFields = ['codigo', 'CodigodoTipodeOperacao', 'UnidadedeControle', 'ProdutoInspecionado', 'ProdutoFabricado', 'ProdutoLiberado', 'ProdutoemInventario', 'TipodeProduto', 'IndicacaodeLoteSerie', 'CodigodeSituacaoTributariaCST', 'ClassificacaoFiscal', 'GrupodeProduto'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'codigo' => ['label'=> 'Codigo', 'rules'=>'permit_empty|max_length[20]'],
        'CodigodoTipodeOperacao' => ['label'=> 'Codigo do Tipo de Operacao', 'rules'=>'required|max_length[3]'],
        'UnidadedeControle' => ['label'=> 'Unidade de Controle', 'rules'=>'required|max_length[10]'],
        'ProdutoInspecionado' => ['label'=> 'Produto Inspecionado', 'rules'=>'required|in_list[S,N]|max_length[10]'],
        'ProdutoFabricado' => ['label'=> 'Produto Fabricado', 'rules'=>'required|in_list[S,N]|max_length[10]'],
        'ProdutoLiberado' => ['label'=> 'Produto Liberado', 'rules'=>'required|in_list[S,N]|max_length[10]'],
        'ProdutoemInventario' => ['label'=> 'Produto em Inventario', 'rules'=>'required|in_list[S,N]|max_length[10]'],
        'TipodeProduto' => ['label'=> 'Tipo de Produto', 'rules'=>'required|in_list[P,S]|max_length[10]'],
        'IndicacaodeLoteSerie' => ['label'=> 'Indicacao de Lote Serie', 'rules'=>'required|in_list[N,L,S]|max_length[10]'],
        'CodigodeSituacaoTributariaCST' => ['label'=> 'Codigo de Situacao Tributaria CST', 'rules'=>'required|in_list[0,1,2]|max_length[10]'],
        'ClassificacaoFiscal' => ['label'=> 'Classificacao Fiscal', 'rules'=>'required|max_length[10]'],
        'GrupodeProduto' => ['label'=> 'Grupo de Produto', 'rules'=>'required|max_length[30]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\DadosApiEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['codigo'])) $this->like('codigo', $data['codigo']);
        if(isset($data['CodigodoTipodeOperacao'])) $this->like('CodigodoTipodeOperacao', $data['CodigodoTipodeOperacao']);
        if(isset($data['UnidadedeControle'])) $this->like('UnidadedeControle', $data['UnidadedeControle']);
        if(isset($data['ProdutoInspecionado'])) $this->like('ProdutoInspecionado', $data['ProdutoInspecionado']);
        if(isset($data['ProdutoFabricado'])) $this->like('ProdutoFabricado', $data['ProdutoFabricado']);
        if(isset($data['ProdutoLiberado'])) $this->like('ProdutoLiberado', $data['ProdutoLiberado']);
        if(isset($data['ProdutoemInventario'])) $this->like('ProdutoemInventario', $data['ProdutoemInventario']);
        if(isset($data['TipodeProduto'])) $this->like('TipodeProduto', $data['TipodeProduto']);
        if(isset($data['IndicacaodeLoteSerie'])) $this->like('IndicacaodeLoteSerie', $data['IndicacaodeLoteSerie']);
        if(isset($data['CodigodeSituacaoTributariaCST'])) $this->like('CodigodeSituacaoTributariaCST', $data['CodigodeSituacaoTributariaCST']);
        if(isset($data['ClassificacaoFiscal'])) $this->like('ClassificacaoFiscal', $data['ClassificacaoFiscal']);
        if(isset($data['GrupodeProduto'])) $this->like('GrupodeProduto', $data['GrupodeProduto']);
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){
        $this->orLike('codigo', $searchTerm);
        $this->orLike('CodigodoTipodeOperacao', $searchTerm);
        $this->orLike('UnidadedeControle', $searchTerm);
        $this->orLike('ProdutoInspecionado', $searchTerm);
        $this->orLike('ProdutoFabricado', $searchTerm);
        $this->orLike('ProdutoLiberado', $searchTerm);
        $this->orLike('ProdutoemInventario', $searchTerm);
        $this->orLike('TipodeProduto', $searchTerm);
        $this->orLike('IndicacaodeLoteSerie', $searchTerm);
        $this->orLike('CodigodeSituacaoTributariaCST', $searchTerm);
        $this->orLike('ClassificacaoFiscal', $searchTerm);
        $this->orLike('GrupodeProduto', $searchTerm);
        
        return $this;
    }
    
}
