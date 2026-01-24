<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ArquivoOficinaModel extends BaseModel{
    
    protected $table = 'ArquivoOficina';
    protected $allowedFields = ['OficinaTematica_id', 'nome', 'arquivo'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'OficinaTematica_id' => ['label'=> 'Oficina Temática', 'rules'=>'required|is_natural_no_zero|is_not_unique[OficinaTematica.id]'],
        'nome' => ['label'=> 'Nome', 'rules'=>'required'],
        'arquivo' => ['label'=> 'Arquivo', 'rules'=>'required'],
    ];
    protected $validationRulesFiles = [
        'arquivo' => ['label'=> 'Arquivo', 'rules'=>'ext_in[arquivo,doc,pdf,xls]|max_size[arquivo,20480]'],
    ];
    protected $returnType = \App\Entities\ArquivoOficinaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['OficinaTematica_id'])) $this->where('OficinaTematica_id =', $data['OficinaTematica_id']); 
        if(isset($data['nome'])) $this->like('nome', $data['nome']); 
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('nome', $searchTerm);        
        return $this;
    }
    
}
