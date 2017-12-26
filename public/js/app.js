Vue.component('modal', {
  template: '#modal-template'
})

new Vue({
  el: '#app',
  data: {
    modalActive: false,
    search: '',
    source: [],
    recs: [],
    currentRec: 0,
    perPage: 10,
    currentPageNum: 1
  },
  computed: {
    posts: function() {
      return this.source.filter(post => {
            return post.title.toLowerCase().includes(this.search.toLowerCase())
          });
    },
    totalPosts: function() {
      return this.posts.length;
    },
    currentPage: function(){
      if(!this.posts.length) return [];

      var begin = (this.currentPageNum - 1)*this.perPage;
      var end = begin + this.perPage;

      result = [];
      for(var i = begin; i < end; i++){
        if(this.posts[i])
          result.push(this.posts[i]);
      }

      console.log(result);
      return result;
    }
  },
  methods: {
    loadPosts: function() {
      this.$http.get('/api/v1/task', {}).then(function(response) {

        this.source = response.data;
        this.turnPage(1);

      }, console.log)
    },
    turnPage: function(page) {
      this.currentPageNum = page;
    },
    getRec: function(id) {
      if(this.recs[id])
      {
        this.currentRec = this.recs[id];
        this.showModal();
      }
      else{
        this.$http.get('/api/v1/task/'+id, {}).then(function(response) {

          this.recs[id] = response.data;
          this.currentRec = this.recs[id];

          this.showModal();
        }, console.log)
      }
    },
    showModal: function(){
      this.modalActive = true;
    }
  },
  created: function() {
    this.loadPosts()
  }
})