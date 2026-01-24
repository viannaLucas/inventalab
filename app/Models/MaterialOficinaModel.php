<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class MaterialOficinaModel extends BaseModel{
    
    protected $table = 'MaterialOficina';
    protected $allowedFields = ['OficinaTematica_id', 'descricao', 'foto'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'OficinaTematica_id' => ['label'=> 'Oficina Temática', 'rules'=>'required|is_natural_no_zero|is_not_unique[OficinaTematica.id]'],
        'descricao' => ['label'=> 'Descrição', 'rules'=>'required'],
        'foto' => ['label'=> 'Foto', 'rules'=>'permit_empty'],
    ];
    protected $validationRulesFiles = [
        'foto' => ['label'=> 'Foto', 'rules'=>'is_image[foto]|max_size[foto,10240]|ext_in[foto,jpg,jpeg,webp,png]'],
    ];
    protected $returnType = \App\Entities\MaterialOficinaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['OficinaTematica_id'])) $this->where('OficinaTematica_id =', $data['OficinaTematica_id']); 
        if(isset($data['descricao'])) $this->like('descricao', $data['descricao']); 
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('descricao', $searchTerm);        
        return $this;
    }
    
}
