<template>
  <div style="padding: 40px; font-family: Arial;">
    <h1>Gerenciar Colaboradores</h1>
    
    <div style="margin-bottom: 30px;">
      <input v-model="form.nome" placeholder="Nome">
      <input v-model="form.email" placeholder="E-mail">
      <button @click="salvar">Salvar no Banco</button>
    </div>

    <p v-if="mensagem">{{ mensagem }}</p>

    <table border="1" style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="background: #eee;">
          <th>ID</th>
          <th>Nome</th>
          <th>E-mail</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="colab in lista" :key="colab.id">
          <td>{{ colab.id }}</td>
          <td>{{ colab.nome }}</td>
          <td>{{ colab.email }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const form = ref({ nome: '', email: '' });
const lista = ref([]);
const mensagem = ref('');

// Função para buscar os dados do Laravel
const carregarColaboradores = async () => {
  const res = await axios.get('http://localhost:8000/api/colaboradores');
  lista.value = res.data;
};

// Salvar e atualizar a lista
const salvar = async () => {
  try {
    await axios.post('http://localhost:8000/api/colaboradores', form.value);
    mensagem.value = "Cadastrado com sucesso!";
    form.value = { nome: '', email: '' };
    carregarColaboradores(); // Recarrega a tabela automaticamente
  } catch (e) {
    mensagem.value = "Erro ao salvar!";
  }
};

// Executa ao abrir a página
onMounted(carregarColaboradores);
</script>