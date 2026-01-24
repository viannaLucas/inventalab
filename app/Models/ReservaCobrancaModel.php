<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ReservaCobrancaModel extends BaseModel{
    
    protected $table = 'ReservaCobranca';
    protected $allowedFields = ['Reserva_id', 'Cobranca_id'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Reserva_id' => ['label'=> 'Reserva', 'rules'=>'required|is_natural_no_zero|is_not_unique[Reserva.id]'],
        'Cobranca_id' => ['label'=> 'Cobrança', 'rules'=>'required|is_natural_no_zero|is_not_unique[Cobranca.id]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\ReservaCobrancaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Reserva_id'])) $this->where('Reserva_id =', $data['Reserva_id']); 
        if(isset($data['Cobranca_id'])) $this->where('Cobranca_id =', $data['Cobranca_id']);  
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
