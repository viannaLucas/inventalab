<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class PresencaEventoModel extends BaseModel{
    
    protected $table = 'PresencaEvento';
    protected $allowedFields = ['ParticipanteEvento_id', 'ControlePresenta_id', 'presente'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'ParticipanteEvento_id' => ['label'=> 'Participante Evento', 'rules'=>'required|is_natural_no_zero|is_not_unique[ParticipanteEvento.id]'],
        'ControlePresenta_id' => ['label'=> 'Controle Presenta', 'rules'=>'required|is_natural_no_zero|is_not_unique[ControlePresenca.id]'],
        'presente' => ['label'=> 'Presente', 'rules'=>'required|in_list[0,1]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\PresencaEventoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['ParticipanteEvento_id'])) $this->where('ParticipanteEvento_id =', $data['ParticipanteEvento_id']); 
        if(isset($data['ControlePresenta_id'])) $this->where('ControlePresenta_id =', $data['ControlePresenta_id']); 
        if(isset($data['presente'])){
            $func = is_array($data['presente']) ? 'whereIn' : 'where';
            $this->$func('presente', $data['presente']);
        } 
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
