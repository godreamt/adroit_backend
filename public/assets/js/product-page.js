var app = new Vue({
    el: '#product-page-app',
    data: {
      categoryList: [],
      subCategoryList: [],
      productList: [],
      totalItems: 1,
      perPageItems: 1,
      currentPage: 1,
      lastPage: 1,
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
      this.filterResult();
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
            let category = $('#category').val();
            this.categoryList.forEach(elem => {
              if(elem.slug == category) {
                this.formData.categories.push(elem.id);
                this.filterResult();
              }
            })
          })
      },
      
      getSubCategories: function() {
        this.formData.subCategories=[]
        axios.post('/api/sub-category/web-list', {catList: this.listCategoryWatch})
          .then(response => {
            this.subCategoryList = response.data;
          })
      },
      
      filterResult: function(page=1) {
        // this.productList=[1,2,3]
        this.formData.pageNumber = page;
        let data = {...this.formData};
        data.isBestSeller = data.bestSeller?'bestseller':''
        axios.post('/api/product/list/paginate', data)
          .then(({data}) => {
            this.productList = data.data;
            this.lastPage = data.last_page;
            this.currentPage = data.current_page;
            window.scrollTo(0, 0);
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