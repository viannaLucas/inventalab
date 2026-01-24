<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ServicoDadosApiModel extends BaseModel{
    
    protected $table = 'ServicoDadosApi';
    protected $allowedFields = ['Servico_id', 'DadosApi_id'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Servico_id' => ['label'=> 'Servico', 'rules'=>'required|is_natural_no_zero|is_not_unique[Servico.id]'],
        'DadosApi_id' => ['label'=> 'Dados API', 'rules'=>'required|is_natural_no_zero|is_not_unique[DadosApi.id]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\ServicoDadosApiEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Servico_id'])) $this->where('Servico_id =', $data['Servico_id']);
        if(isset($data['DadosApi_id'])) $this->where('DadosApi_id =', $data['DadosApi_id']);
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
