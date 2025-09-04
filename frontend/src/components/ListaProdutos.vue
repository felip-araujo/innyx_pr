<template>
    <div class="p-6 space-y-4">
      <!-- Cabeçalho -->
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Lista de Produtos</h1>
        <button
          @click="novoProduto"
          class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition"
        >
          Novo Produto
        </button>
      </div>
  
      <!-- Busca -->
      <input
        type="text"
        v-model="search"
        placeholder="Buscar por nome ou descrição"
        class="border p-2 rounded w-full"
        @input="onInputSearch"
      />
  
      <!-- Tabela de Produtos -->
      <table class="w-full bg-white shadow rounded overflow-hidden">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2 text-left">Nome</th>
            <th class="p-2 text-left">Descrição</th>
            <th class="p-2 text-left">Preço</th>
            <th class="p-2 text-left">Data Validade</th>
            <th class="p-2 text-left">Categoria</th>
            <th class="p-2">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="produto in produtos.data" :key="produto.id" class="border-b hover:bg-gray-50">
            <td class="p-2">{{ produto.nome }}</td>
            <td class="p-2">{{ produto.descricao }}</td>
            <td class="p-2">{{ produto.preco }}</td>
            <td class="p-2">{{ produto.data_validade }}</td>
            <td class="p-2">{{ produto.categoria.nome }}</td>
            <td class="p-2 space-x-2">
              <button
                @click="editar(produto)"
                class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition"
              >
                Editar
              </button>
              <button
                @click="deletar(produto.id)"
                class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition"
              >
                Excluir
              </button>
            </td>
          </tr>
          <tr v-if="produtos.data.length === 0">
            <td colspan="6" class="p-4 text-center text-gray-500">Nenhum produto encontrado</td>
          </tr>
        </tbody>
      </table>
  
      <!-- Paginação -->
      <div class="flex justify-between mt-4">
        <button
          :disabled="!produtos.prev_page_url"
          @click="fetchProdutos(produtos.prev_page_url)"
          class="px-3 py-1 bg-gray-300 rounded disabled:opacity-50"
        >
          Anterior
        </button>
        <button
          :disabled="!produtos.next_page_url"
          @click="fetchProdutos(produtos.next_page_url)"
          class="px-3 py-1 bg-gray-300 rounded disabled:opacity-50"
        >
          Próximo
        </button>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  
  interface Categoria {
    id: number
    nome: string
  }
  
  interface Produto {
    id: number
    nome: string
    descricao: string
    preco: number
    data_validade: string
    categoria: Categoria
  }
  
  interface Paginate<T> {
    data: T[]
    current_page: number
    last_page: number
    next_page_url: string | null
    prev_page_url: string | null
  }
  
  const produtos = ref<Paginate<Produto>>({
    data: [],
    current_page: 1,
    last_page: 1,
    next_page_url: null,
    prev_page_url: null
  })
  
  const search = ref('')
  
  // Wrapper para input para evitar erro TS
  const onInputSearch = () => {
    fetchProdutos()
  }
  
  // Função para buscar produtos
  const fetchProdutos = async (url?: string) => {
    try {
      const endpoint = url || 'http://127.0.0.1:8000/api/products'
      const res = await axios.get(endpoint, { params: { search: search.value } })
      produtos.value = res.data
    } catch (err) {
      console.error(err)
    }
  }
  
  // Criar novo produto
  const novoProduto = () => {
    alert('Abrir modal ou rota para criar novo produto')
  }
  
  // Editar produto
  const editar = (produto: Produto) => {
    alert(`Editar produto ${produto.nome} (implemente modal ou rota de edição)`)
  }
  
  // Excluir produto
  const deletar = async (id: number) => {
    if (!confirm('Deseja realmente excluir este produto?')) return
    try {
      await axios.delete(`http://127.0.0.1:8000/api/products/${id}`)
      fetchProdutos()
    } catch (err) {
      console.error(err)
    }
  }
  
  onMounted(() => {
    fetchProdutos()
  })
  </script>
  