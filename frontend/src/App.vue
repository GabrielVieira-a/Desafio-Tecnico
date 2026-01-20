<template>
  <div style="padding: 40px; font-family: sans-serif; max-width: 1100px; margin: auto;">
    
    <div v-if="!logado" style="max-width: 400px; margin: 100px auto; padding: 30px; border: 1px solid #ddd; border-radius: 8px; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
      <h2 style="text-align: center; color: #333;">Login do Sistema</h2>
      <div style="margin-bottom: 15px;">
        <label>E-mail:</label>
        <input v-model="formLogin.email" type="email" placeholder="admin@teste.com" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
      </div>
      <div style="margin-bottom: 20px;">
        <label>Senha:</label>
        <input v-model="formLogin.password" type="password" placeholder="******" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
      </div>
      <button @click="fazerLogin" style="width: 100%; padding: 12px; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
        ENTRAR
      </button>
      <p v-if="mensagem" style="color: #c62828; margin-top: 15px; text-align: center; font-weight: bold;">{{ mensagem }}</p>
    </div>

    <div v-else>
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Gestão de Ativos</h1>
        <button @click="fazerLogout" style="background: #f44336; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold;">
          SAIR
        </button>
      </div>

      <div v-if="mensagem" 
          :style="{ 
            padding: '15px', marginBottom: '20px', borderRadius: '4px',
            backgroundColor: mensagem.includes('Erro') ? '#ffebee' : '#e3f2fd',
            color: mensagem.includes('Erro') ? '#c62828' : '#0d47a1',
            border: '1px solid'
          }">
        {{ mensagem }}
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
        <section style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #f9f9f9;">
          <h2>1. Cadastrar Produto (Modelo)</h2>
          <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 15px;">
            <input v-model="formProduto.nome" placeholder="Ex: Latitude 3420" style="padding: 8px;">
            <input v-model="formProduto.marca" placeholder="Ex: Dell" style="padding: 8px;">
            <button @click="salvarProduto" style="background: #673AB7; color: white; border: none; padding: 10px; cursor: pointer; border-radius: 4px;">
              Cadastrar Produto
            </button>
          </div>
          
          <div style="max-height: 150px; overflow-y: auto; border: 1px solid #ccc; background: #fff;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9em;">
              <thead style="background: #eee; position: sticky; top: 0;">
                <tr><th style="padding: 5px; text-align: left;">Modelo</th><th style="padding: 5px; text-align: left;">Marca</th></tr>
              </thead>
              <tbody>
                <tr v-for="p in produtos" :key="p.id">
                  <td style="padding: 5px; border-top: 1px solid #eee;">{{ p.nome }}</td>
                  <td style="padding: 5px; border-top: 1px solid #eee;">{{ p.marca }}</td>
                </tr>
                <tr v-if="produtos.length === 0">
                  <td colspan="2" style="text-align: center; padding: 10px; color: #999;">Nenhum modelo na lista.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <section style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #f9f9f9;">
          <h2>2. Cadastrar Colaborador</h2>
          <div style="display: flex; flex-direction: column; gap: 10px;">
            <input v-model="formColab.nome" placeholder="Nome Completo" style="padding: 8px;">
            <input v-model="formColab.email" placeholder="E-mail Corporativo" style="padding: 8px;">
            <button @click="salvarColaborador" style="background: #4CAF50; color: white; border: none; padding: 10px; cursor: pointer; border-radius: 4px;">
              Cadastrar Colaborador
            </button>
          </div>
        </section>
      </div>

      <section style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 40px;">
        <h2>3. Inventário de Ativos</h2>
        <div style="margin-bottom: 20px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
          <input v-model="formAtivo.nome" placeholder="Nome do Ativo" style="padding: 8px;">
          <input v-model="formAtivo.numero_serie" placeholder="Nº Série" style="padding: 8px;">
          <select v-model="formAtivo.produto_id" style="padding: 8px;">
            <option :value="null">Selecione o Modelo</option>
            <option v-for="p in produtos" :key="p.id" :value="p.id">{{ p.nome }} ({{ p.marca }})</option>
          </select>
          <button @click="salvarAtivo" style="grid-column: span 3; background: #2196F3; color: white; border: none; padding: 10px; cursor: pointer; border-radius: 4px;">
            Adicionar ao Inventário
          </button>
        </div>

        <table border="1" style="width: 100%; border-collapse: collapse; text-align: left; background: white;">
          <thead>
            <tr style="background: #eee;">
              <th style="padding: 10px;">Equipamento</th>
              <th style="padding: 10px;">Série</th>
              <th style="padding: 10px;">Responsável Atual</th>
              <th style="padding: 10px;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="a in ativos" :key="a.id">
              <td style="padding: 10px;">{{ a.nome }}</td>
              <td style="padding: 10px;"><code>{{ a.numero_serie }}</code></td>
              <td style="padding: 10px;">
                <select v-model="a.colaborador_id" style="padding: 5px;">
                  <option :value="null">Disponível (Estoque)</option>
                  <option v-for="c in colaboradores" :key="c.id" :value="c.id">{{ c.nome }}</option>
                </select>
                <button @click="vincularEquipamento(a.id, a.colaborador_id)" style="background: #ff9800; color: white; border: none; padding: 5px 10px; margin-left: 5px; cursor: pointer; border-radius: 4px;">
                  OK
                </button>
              </td>
              <td style="padding: 10px; text-align: center;">
                <button @click="excluirAtivo(a.id)" style="background: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px;">
                  Remover
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </section>

      <section style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #fff;">
        <h2>Histórico de Movimentações</h2>
        <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
          <thead style="background: #333; color: white;">
            <tr>
              <th style="padding: 10px;">Data/Hora</th>
              <th style="padding: 10px;">Ativo</th>
              <th style="padding: 10px;">Tipo</th>
              <th style="padding: 10px;">Colaborador</th>
              <th style="padding: 10px;">Realizado por</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="h in historico" :key="h.id">
              <td style="padding: 8px;">{{ formatarData(h.data_hora) }}</td>
              <td style="padding: 8px;">{{ h.ativo?.nome }}</td>
              <td style="padding: 8px;">
                <span :style="{ color: h.tipo === 'Entrega' ? 'green' : 'orange', fontWeight: 'bold' }">
                  {{ h.tipo }}
                </span>
              </td>
              <td style="padding: 8px;">{{ h.colaborador?.nome || 'Retorno ao Estoque' }}</td>
              <td style="padding: 8px; color: #666;">{{ h.realizado_por }}</td>
            </tr>
          </tbody>
        </table>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const api = "http://localhost:8000/api";
const logado = ref(false);
const mensagem = ref('');

const formLogin = ref({ email: '', password: '' });
const formProduto = ref({ nome: '', marca: '' });
const formColab = ref({ nome: '', email: '' });
const formAtivo = ref({ nome: '', tipo: 'Hardware', numero_serie: '', produto_id: null });

const produtos = ref([]);
const colaboradores = ref([]);
const ativos = ref([]);
const historico = ref([]);

// FUNÇÃO DE CARREGAMENTO COM DIAGNÓSTICO 
const carregarDados = async () => {
  const token = localStorage.getItem('token');
  if (!token) return;

  const config = { headers: { Authorization: `Bearer ${token}` } };

  try {
    console.log("Sincronizando dados com o servidor...");
    const [resP, resC, resA, resH] = await Promise.all([
      axios.get(`${api}/produtos`, config),
      axios.get(`${api}/colaboradores`, config),
      axios.get(`${api}/ativos`, config),
      axios.get(`${api}/movimentacoes`, config)
    ]);
    
    produtos.value = resP.data;
    colaboradores.value = resC.data;
    ativos.value = resA.data;
    historico.value = resH.data;
    
    console.log("Dados carregados com sucesso. Total de produtos:", produtos.value.length);
  } catch (e) {
    console.error("Falha na sincronização:", e.response?.status, e.response?.data);
    if (e.response?.status === 401) fazerLogout();
  }
};

const fazerLogin = async () => {
  mensagem.value = "";
  try {
    const res = await axios.post(`${api}/login`, formLogin.value);
    const token = res.data.access_token;
    localStorage.setItem('token', token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    logado.value = true;
    mensagem.value = "Login realizado!";
    await carregarDados();
  } catch (e) { mensagem.value = "Erro: E-mail ou senha inválidos."; }
};

const salvarProduto = async () => {
  if (!formProduto.value.nome || !formProduto.value.marca) return;
  const token = localStorage.getItem('token');
  try {
    const res = await axios.post(`${api}/produtos`, formProduto.value, {
      headers: { Authorization: `Bearer ${token}` }
    });
    
    if (res.status === 201 || res.status === 200) {
      mensagem.value = "Produto cadastrado com sucesso!";
      formProduto.value = { nome: '', marca: '' };
      
      
      setTimeout(carregarDados, 400);
    }
  } catch (e) { 
    mensagem.value = "Erro ao salvar produto."; 
    console.error(e);
  }
};

const salvarColaborador = async () => {
  try {
    await axios.post(`${api}/colaboradores`, formColab.value);
    mensagem.value = "Colaborador salvo!";
    formColab.value = { nome: '', email: '' };
    await carregarDados();
  } catch (e) { mensagem.value = "Erro ao salvar colaborador."; }
};

const salvarAtivo = async () => {
  if (!formAtivo.value.produto_id) return mensagem.value = "Selecione o modelo!";
  try {
    await axios.post(`${api}/ativos`, formAtivo.value);
    mensagem.value = "Ativo adicionado!";
    formAtivo.value = { nome: '', tipo: 'Hardware', numero_serie: '', produto_id: null };
    await carregarDados();
  } catch (e) { mensagem.value = "Erro ao cadastrar ativo."; }
};

const vincularEquipamento = async (ativoId, colabId) => {
  try {
    await axios.post(`${api}/movimentacoes`, { ativo_id: ativoId, colaborador_id: colabId });
    mensagem.value = "Vínculo atualizado!";
    await carregarDados();
  } catch (e) { mensagem.value = "Erro na movimentação."; }
};

const excluirAtivo = async (id) => {
  if (confirm("Excluir este ativo?")) {
    try {
      await axios.delete(`${api}/ativos/${id}`);
      await carregarDados();
    } catch (e) { mensagem.value = "Erro ao excluir."; }
  }
};

const formatarData = (dataStr) => {
  if (!dataStr) return "-";
  return new Date(dataStr).toLocaleString('pt-BR');
};

const fazerLogout = () => {
  localStorage.removeItem('token');
  delete axios.defaults.headers.common['Authorization'];
  logado.value = false;
};

const verificarSessao = () => {
  const token = localStorage.getItem('token');
  if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    logado.value = true;
    carregarDados();
  }
};

onMounted(verificarSessao);
</script>