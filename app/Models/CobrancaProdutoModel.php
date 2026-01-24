<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class CobrancaProdutoModel extends BaseModel{
    
    protected $table = 'CobrancaProduto';
    protected $allowedFields = ['Cobranca_id', 'Produto_id', 'quantidade', 'valorUnitario'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Cobranca_id' => ['label'=> 'Cobrança', 'rules'=>'required|is_natural_no_zero|is_not_unique[Cobranca.id]'],
        'Produto_id' => ['label'=> 'Produto', 'rules'=>'required|is_natural_no_zero|is_not_unique[Produto.id]'],
        'quantidade' => ['label'=> 'Quantidade', 'rules'=>'required|greater_than[0]|integer'],
        'valorUnitario' => ['label'=> 'Valor Unitário', 'rules'=>'required|greater_than[0]|decimal'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\CobrancaProdutoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Cobranca_id'])) $this->where('Cobranca_id =', $data['Cobranca_id']); 
        if(isset($data['Produto_id'])) $this->where('Produto_id =', $data['Produto_id']); 
        if(isset($data['quantidadeStart'])) $this->where('quantidade >=', $data['quantidadeStart']);
        if(isset($data['quantidadeEnd'])) $this->where('quantidade <=', $data['quantidadeEnd']);
        if(isset($data['valorUnitarioStart'])) $this->where('valorUnitario >=', CastCurrencyBR::set($data['valorUnitarioStart']));
        if(isset($data['valorUnitarioEnd'])) $this->where('valorUnitario <=', CastCurrencyBR::set($data['valorUnitarioEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
