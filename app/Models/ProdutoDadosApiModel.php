<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ProdutoDadosApiModel extends BaseModel{
    
    protected $table = 'ProdutoDadosApi';
    protected $allowedFields = ['Produto_id', 'DadosApi_id'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Produto_id' => ['label'=> 'Produto', 'rules'=>'required|is_natural_no_zero|is_not_unique[Produto.id]'],
        'DadosApi_id' => ['label'=> 'Dados API', 'rules'=>'required|is_natural_no_zero|is_not_unique[DadosApi.id]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\ProdutoDadosApiEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Produto_id'])) $this->where('Produto_id =', $data['Produto_id']);
        if(isset($data['DadosApi_id'])) $this->where('DadosApi_id =', $data['DadosApi_id']);
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
