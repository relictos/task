<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Результаты</title>
  <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>

<template id="pagination-template">
  <div class="pagination">
    <div class="pagination__left">
      <a href="#" v-if="hasPrev()" @click.prevent="changePage(prevPage)"><</a>
    </div>
    <div class="pagination__mid">
      <ul>
        <li v-if="hasFirst()"><a href="#" @click.prevent="changePage(1)">1</a></li>
        <li v-if="hasFirst()">...</li>
        <li v-for="page in pages">
          <a href="#" @click.prevent="changePage(page)" :class="{ current: current == page }">
            @{{ page }}
          </a>
        </li>
        <li v-if="hasLast()">...</li>
        <li v-if="hasLast()"><a href="#" @click.prevent="changePage(totalPages)">@{{ totalPages }}</a></li>
      </ul>
    </div>
    <div class="pagination__right">
      <a href="#" v-if="hasNext()" @click.prevent="changePage(nextPage)">
        >
      </a>
    </div>
  </div>
</template>

<!-- template for the modal component -->
<script type="text/x-template" id="modal-template">
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <slot name="header"></slot>
          </div>
          <div class="modal-body">
            <slot name="body"></slot>
          </div>
          <div class="modal-footer">
            <slot name="footer">
              <button class="modal-default-button" @click="$emit('close')">
              Закрыть
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</script>


<div id="app">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-push-2">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Поиск по заголовку" v-model="search">
        </div>

        <table class="table">
          <tr>
            <th>Номер задачи</th>
            <th>Заголовок</th>
            <th>Дата исполнения</th>
          </tr>
          <tr v-for="post in currentPage" @click.prevent="getRec(post.id)">
            <td>@{{ post.id }}</td>
            <td>@{{ post.title }}</td>
            <td>@{{ post.date }}</td>
          </tr>
        </table>

        <pagination
            :current="currentPageNum"
            :total="totalPosts"
            :per-page="perPage"
        @page-changed="turnPage"
        ></pagination>

        <modal v-if="modalActive" @close="modalActive = false">
          <h3 slot="header">Информация о задаче @{{ currentRec.id }}</h3>
          <div class="row" slot="body">
            <div class="col-md-6">Заголовок:</div>
            <div class="col-md-6"><b>@{{ currentRec.title }}</b></div>
            <div class="col-md-6">Дата выполнения:</div>
            <div class="col-md-6"><b>@{{ currentRec.date }}</b></div>
            <div class="col-md-6">Автор:</div>
            <div class="col-md-6"><b>@{{ currentRec.author }}</b></div>
            <div class="col-md-6">Статус:</div>
            <div class="col-md-6"><b>@{{ currentRec.status }}</b></div>
            <div class="col-md-6">Описание:</div>
            <div class="col-md-6"><b>@{{ currentRec.description }}</b></div>
          </div>
        </modal>
      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/vue.resource/1.0.3/vue-resource.min.js"></script>
<script src="{{asset('js/pagination.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>