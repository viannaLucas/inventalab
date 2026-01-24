<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class HorarioFuncionamentoModel extends BaseModel{
    
    protected $table = 'HorarioFuncionamento';
    protected $allowedFields = ['diaSemana', 'horaInicio', 'horaFinal'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'diaSemana' => ['label'=> 'Dia da Semana', 'rules'=>'required|in_list[0,1,2,3,4,5,6]'],
        'horaInicio' => ['label'=> 'Hora Início', 'rules'=>'required|horaBR'],
        'horaFinal' => ['label'=> 'Hora Final', 'rules'=>'required|horaBR'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\HorarioFuncionamentoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['horaInicio'])) $this->like('horaInicio', $data['horaInicio']);
        if(isset($data['horaFinal'])) $this->like('horaFinal', $data['horaFinal']);
        if(isset($data['diaSemana'])){
            $func = is_array($data['diaSemana']) ? 'whereIn' : 'where';
            $this->$func('diaSemana', $data['diaSemana']);
        } 
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('horaInicio', $searchTerm);
        $this->orLike('horaFinal', $searchTerm);        
        return $this;
    }
    
}
