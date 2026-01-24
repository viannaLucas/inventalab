<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class OficinaTematicaModel extends BaseModel{
    
    protected $table = 'OficinaTematica';
    protected $allowedFields = ['nome', 'descricaoAtividade', 'situacao'];
    protected array $sanitizeHtmlFields = ['descricaoAtividade'];
    protected $beforeInsert = ['sanitizeHtmlFields'];
    protected $beforeUpdate = ['sanitizeHtmlFields'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'nome' => ['label'=> 'Nome', 'rules'=>'required'],
        'descricaoAtividade' => ['label'=> 'Descrição Atividade', 'rules'=>'required'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\OficinaTematicaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        $this->where('situacao', 0);
        if(isset($data['nome'])) $this->like('nome', $data['nome']); 
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->builder()->resetQuery();
        $this->where('situacao', 0);
        $this->like('nome', $searchTerm);        
        return $this;
    }

    public function marcarExcluido(int $id): bool
    {
        $this->skipValidation(true);
        $ret = $this->update($id, ['situacao' => 1]);
        $this->skipValidation(false);

        return $ret;
    }
    
}
