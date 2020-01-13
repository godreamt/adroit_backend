var app = new Vue({
    el: '#enquiry-app',
    data: {
      enquiryData: {
        fullName: "",
        email: "",
        mobileNumber: "",
        customerInfo: "",
        enquiryText: "",
        status: "new"
      },
      result: "",
      error: ""
    },
    mounted: function(){
    },
    methods: {
        sendEnquiry: function(event) {
            event.preventDefault();
            axios.post('/api/site-manager/enquiry', this.enquiryData).then(response => {
                this.enquiryData = {
                    fullName: "",
                    email: "",
                    mobileNumber: "",
                    customerInfo: "",
                    enquiryText: "",
                    status: "new"
                  };
                  this.error = "";
                this.result = "Enquiry sent successfully. We will get back to you soon";
            }).catch(error => {
                this.result="";
                this.error = "Given Data is invalid";
            })
        }
    },
    delimiters: ['<%', '%>']

  })