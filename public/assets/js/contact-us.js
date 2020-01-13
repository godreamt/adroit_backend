var app = new Vue({
    el: '#contact-us-app',
    data: {
      contactData: {
        fullName: "",
        email: "",
        mobileNumber: "",
        reasonText: "",
        status: "new"
      },
      result: "",
      error: ""
    },
    mounted: function(){
    },
    methods: {
        sendContact: function(event) {
            event.preventDefault();
            axios.post('/api/site-manager/contact', this.contactData).then(response => {
                this.contactData = {
                    fullName: "",
                    email: "",
                    mobileNumber: "",
                    reasonText: "",
                    status: "new"
                  };
                  this.error = "";
                this.result = "Contact request sent successfully. We will get back to you soon";
            }).catch(error => {
                this.result="";
                this.error = "Given Data is invalid";
            })
        }
    },
    delimiters: ['<%', '%>']

  })