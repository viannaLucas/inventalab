<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ProdutoModel extends BaseModel{
    
    protected $table = 'Produto';
    protected $allowedFields = ['nome', 'foto', 'valor', 'estoqueMinimo', 'estoqueAtual'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'nome' => ['label'=> 'Nome', 'rules'=>'required'],
        'foto' => ['label'=> 'Foto', 'rules'=>'permit_empty'],
        // 'valor' => ['label'=> 'Valor', 'rules'=>'required|greater_than[0]|decimal'],
        'estoqueMinimo' => ['label'=> 'Estoque Mínimo', 'rules'=>'required|greater_than[0]|integer'],
        'estoqueAtual' => ['label'=> 'Estoque Atual', 'rules'=>'required|greater_than[0]|integer'],
    ];
    protected $validationRulesFiles = [
        'foto' => ['label'=> 'Foto', 'rules'=>'is_image[foto]|max_size[foto,10240]|ext_in[foto,jpg,jpeg,webp,png]'],
    ];
    protected $returnType = \App\Entities\ProdutoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['nome'])) $this->like('nome', $data['nome']);
        if(isset($data['estoqueMinimoStart'])) $this->where('estoqueMinimo >=', $data['estoqueMinimoStart']);
        if(isset($data['estoqueMinimoEnd'])) $this->where('estoqueMinimo <=', $data['estoqueMinimoEnd']);
        if(isset($data['estoqueAtualStart'])) $this->where('estoqueAtual >=', $data['estoqueAtualStart']);
        if(isset($data['estoqueAtualEnd'])) $this->where('estoqueAtual <=', $data['estoqueAtualEnd']); 
        if(isset($data['valorStart'])) $this->where('valor >=', CastCurrencyBR::set($data['valorStart']));
        if(isset($data['valorEnd'])) $this->where('valor <=', CastCurrencyBR::set($data['valorEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('nome', $searchTerm);        
        return $this;
    }

    public function calcularConsumoProdutosPorServicos(array $servicosQuantidade): array
    {
        $servicosQuantidade = $this->normalizarServicosQuantidade($servicosQuantidade);
        if (empty($servicosQuantidade)) {
            return [];
        }

        $mServicoProduto = new \App\Models\ServicoProdutoModel();
        $relacoes = $mServicoProduto->findByServicoIds(array_keys($servicosQuantidade));
        $consumo = [];

        foreach ($relacoes as $relacao) {
            $servicoId = (int) ($relacao->Servico_id ?? 0);
            $produtoId = (int) ($relacao->Produto_id ?? 0);
            $quantidadeProduto = (int) ($relacao->quantidade ?? 0);
            $quantidadeServico = (int) ($servicosQuantidade[$servicoId] ?? 0);

            if ($servicoId <= 0 || $produtoId <= 0 || $quantidadeProduto <= 0 || $quantidadeServico <= 0) {
                continue;
            }

            if (!isset($consumo[$produtoId])) {
                $consumo[$produtoId] = 0;
            }
            $consumo[$produtoId] += $quantidadeServico * $quantidadeProduto;
        }

        return $consumo;
    }

    public function calcularDeltaEstoquePorServicos(array $servicosNovos, array $servicosAntigos = []): array
    {
        $consumoNovo = $this->calcularConsumoProdutosPorServicos($servicosNovos);
        $consumoAntigo = $this->calcularConsumoProdutosPorServicos($servicosAntigos);
        $delta = $consumoNovo;

        foreach ($consumoAntigo as $produtoId => $quantidade) {
            $produtoId = (int) $produtoId;
            if (!isset($delta[$produtoId])) {
                $delta[$produtoId] = 0;
            }
            $delta[$produtoId] -= (int) $quantidade;
            if ($delta[$produtoId] === 0) {
                unset($delta[$produtoId]);
            }
        }

        return $delta;
    }

    public function ajustarEstoquePorDelta(array $deltaProdutos): void
    {
        $deltaProdutos = $this->normalizarDeltaProdutos($deltaProdutos);
        if (empty($deltaProdutos)) {
            return;
        }

        $produtoIds = array_keys($deltaProdutos);
        $this->builder()->resetQuery();
        $produtos = $this->whereIn('id', $produtoIds)->findAll();
        $this->builder()->resetQuery();

        $mapProdutos = [];
        foreach ($produtos as $produto) {
            $mapProdutos[(int) $produto->id] = $produto;
        }

        $erros = [];
        foreach ($deltaProdutos as $produtoId => $delta) {
            $produtoId = (int) $produtoId;
            $delta = (int) $delta;
            $produto = $mapProdutos[$produtoId] ?? null;

            if ($produto === null) {
                $erros[] = 'Produto não encontrado (ID ' . $produtoId . ').';
                continue;
            }

            if ($delta > 0) {
                $estoqueAtual = (int) ($produto->estoqueAtual ?? 0);
                if ($estoqueAtual < $delta) {
                    $nomeProduto = (string) ($produto->nome ?? ('ID ' . $produtoId));
                    $erros[] = 'Estoque insuficiente para o produto ' . $nomeProduto
                        . '. Disponível: ' . $estoqueAtual . ', necessário: ' . $delta . '.';
                }
            }
        }

        if (!empty($erros)) {
            throw new \RuntimeException(implode(' ', $erros));
        }

        foreach ($deltaProdutos as $produtoId => $delta) {
            $produtoId = (int) $produtoId;
            $delta = (int) $delta;
            if ($delta === 0) {
                continue;
            }

            $builder = $this->builder();
            $builder->resetQuery();

            if ($delta > 0) {
                $builder->set('estoqueAtual', 'estoqueAtual - ' . $delta, false)
                    ->where('id', $produtoId)
                    ->where('estoqueAtual >=', $delta);
            } else {
                $incremento = abs($delta);
                $builder->set('estoqueAtual', 'estoqueAtual + ' . $incremento, false)
                    ->where('id', $produtoId);
            }

            $ok = $builder->update();
            if (!$ok || $this->db->affectedRows() === 0) {
                $nomeProduto = isset($mapProdutos[$produtoId])
                    ? (string) ($mapProdutos[$produtoId]->nome ?? ('ID ' . $produtoId))
                    : ('ID ' . $produtoId);
                throw new \RuntimeException('Falha ao atualizar estoque do produto ' . $nomeProduto . '.');
            }
        }

        $this->builder()->resetQuery();
    }

    private function normalizarServicosQuantidade(array $servicosQuantidade): array
    {
        $resultado = [];
        foreach ($servicosQuantidade as $servicoId => $quantidade) {
            $servicoId = (int) $servicoId;
            $quantidade = (int) $quantidade;
            if ($servicoId <= 0 || $quantidade <= 0) {
                continue;
            }
            if (!isset($resultado[$servicoId])) {
                $resultado[$servicoId] = 0;
            }
            $resultado[$servicoId] += $quantidade;
        }
        return $resultado;
    }

    private function normalizarDeltaProdutos(array $deltaProdutos): array
    {
        $resultado = [];
        foreach ($deltaProdutos as $produtoId => $delta) {
            $produtoId = (int) $produtoId;
            $delta = (int) $delta;
            if ($produtoId <= 0 || $delta === 0) {
                continue;
            }
            if (!isset($resultado[$produtoId])) {
                $resultado[$produtoId] = 0;
            }
            $resultado[$produtoId] += $delta;
            if ($resultado[$produtoId] === 0) {
                unset($resultado[$produtoId]);
            }
        }
        return $resultado;
    }
    
}
