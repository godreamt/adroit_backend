var app = new Vue({
    el: '#product-page-app',
    data: {
      categoryList: [],
      subCategoryList: [],
      totalItems: 1,
      perPageItems: 1,
      currentPage: 1,
      totalPages: 1,
      formData: {
        bestSeller: "",
        categories: [],
        subCategories: [],
        pageNumber: 1
      }
    },
    mounted: function(){
      this.getCategories();
      this.perPageItems = $('#perPageItems').val();
      this.totalItems = $('#totalItems').val();
      this.currentPage = $('#currentPage').val();
      this.totalPages = Math.ceil(this.totalItems / this.perPageItems);
    },
    computed: {
      listCategoryWatch() {
        return this.formData.categories;
      }
    },
    watch: {
      listCategoryWatch : function(val){
        
        this.getSubCategories();
        
      }
    },
    methods: {
      getCategories: function() {
        axios.get('/api/category/list', this.formData)
          .then(response => {
            this.categoryList = response.data;
          })
      },
      
      getSubCategories: function() {
        axios.post('/api/sub-category/web-list', {catList: this.listCategoryWatch})
          .then(response => {
            this.subCategoryList = response.data;
          })
      },
      
      filterResult: function(page=1) {
        this.formData.pageNumber = page;
        axios.post('/products', this.formData)
          .then(response => {
            var data = $(response.data).find('#productListContent').html();
            $('#productListContent').html(data);
          })
      },
      gotoPrevious: function() {
        let page = (this.currentPage - 1<=0)?1:this.currentPage - 1;
        this.filterResult(page);
      },
      gotoNext: function() {
        let page = (this.currentPage + 1 > this.totalPages)?this.totalPages:this.currentPage + 1;
        this.filterResult(page);
      }
    },
    delimiters: ['<%', '%>']

  })