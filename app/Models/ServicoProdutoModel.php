<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ServicoProdutoModel extends BaseModel{
    
    protected $table = 'ServicoProduto';
    protected $allowedFields = ['Produto_id', 'Servico_id', 'quantidade'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Produto_id' => ['label'=> 'Produto', 'rules'=>'required|is_natural_no_zero|is_not_unique[Produto.id]'],
        'Servico_id' => ['label'=> 'Serviço', 'rules'=>'required|is_natural_no_zero|is_not_unique[Servico.id]'],
        'quantidade' => ['label'=> 'Quantidade', 'rules'=>'required|greater_than[0]|integer'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\ServicoProdutoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Produto_id'])) $this->where('Produto_id =', $data['Produto_id']); 
        if(isset($data['Servico_id'])) $this->where('Servico_id =', $data['Servico_id']); 
        if(isset($data['quantidadeStart'])) $this->where('quantidade >=', $data['quantidadeStart']);
        if(isset($data['quantidadeEnd'])) $this->where('quantidade <=', $data['quantidadeEnd']);
        
        return $this;
    }

    public function findByServicoIds(array $ids): array
    {
        $ids = array_values(array_filter(array_map('intval', $ids), static fn($id) => $id > 0));
        if (empty($ids)) {
            return [];
        }
        $this->builder()->resetQuery();
        return $this->whereIn('Servico_id', $ids)->findAll();
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
