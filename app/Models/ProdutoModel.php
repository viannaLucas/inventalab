<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ProdutoModel extends BaseModel{
    
    protected $table = 'Produto';
    protected $allowedFields = ['nome', 'foto', 'valor', 'estoqueMinimo', 'estoqueAtual'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'nome' => ['label'=> 'Nome', 'rules'=>'required'],
        'foto' => ['label'=> 'Foto', 'rules'=>'permit_empty'],
        // 'valor' => ['label'=> 'Valor', 'rules'=>'required|greater_than[0]|decimal'],
        'estoqueMinimo' => ['label'=> 'Estoque Mínimo', 'rules'=>'required|greater_than[0]|integer'],
        'estoqueAtual' => ['label'=> 'Estoque Atual', 'rules'=>'required|greater_than[0]|integer'],
    ];
    protected $validationRulesFiles = [
        'foto' => ['label'=> 'Foto', 'rules'=>'is_image[foto]|max_size[foto,10240]|ext_in[foto,jpg,jpeg,webp,png]'],
    ];
    protected $returnType = \App\Entities\ProdutoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['nome'])) $this->like('nome', $data['nome']);
        if(isset($data['estoqueMinimoStart'])) $this->where('estoqueMinimo >=', $data['estoqueMinimoStart']);
        if(isset($data['estoqueMinimoEnd'])) $this->where('estoqueMinimo <=', $data['estoqueMinimoEnd']);
        if(isset($data['estoqueAtualStart'])) $this->where('estoqueAtual >=', $data['estoqueAtualStart']);
        if(isset($data['estoqueAtualEnd'])) $this->where('estoqueAtual <=', $data['estoqueAtualEnd']); 
        if(isset($data['valorStart'])) $this->where('valor >=', CastCurrencyBR::set($data['valorStart']));
        if(isset($data['valorEnd'])) $this->where('valor <=', CastCurrencyBR::set($data['valorEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('nome', $searchTerm);        
        return $this;
    }
    
}
