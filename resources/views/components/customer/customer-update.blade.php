<div class="modal fade" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Customer</h6>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate" value="">

                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control mb-2" id="customerEmailUpdate" value="">

                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control mb-2" id="customerMobileUpdate" value="">

                                <input type="hidden" class="d-none" id="customerID" value="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-danger" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="updateCustomer()" id="update-btn" class="btn btn-success">Update</button>
            </div>
        </div>
    </div>
</div>


<script>


// Assuming 'tableList' is the ID of the table container
document.getElementById('tableList').addEventListener('click', function(event) {
    const target = event.target;
    if (target.classList.contains('editBtn')) {
        const customerId = target.getAttribute('data-id');
        handleEdit(customerId);
        
    }
});


async function handleEdit(customerId) {
   await axios.get(`/customers/${customerId}/edit`)
   .then(function(response) {
        const customerName = document.getElementById('customerNameUpdate');
        const customerEmail = document.getElementById('customerEmailUpdate');
        const customerMobile = document.getElementById('customerMobileUpdate');
        const customerID = document.getElementById('customerID');

        if (response.status === 200) {
            customerName.value = response.data.name;
            customerEmail.value = response.data.email;
            customerMobile.value = response.data.mobile;
            customerID.value = response.data.id;
        }
        
   })
   .catch(function(error){
        alert('Request failed.');
   });
}




    // async function fillUpUpdateForm(id) {
    //     document.getElementById('customerID').value = id;
    //     showLoader();
    //     try {
    //         const response = await axios.get(`/customers/${id}`);
    //         const customerData = response.data;
    //         console.log(customerData);
    //         document.getElementById('customerNameUpdate').value = customerData.name;
    //         document.getElementById('customerEmailUpdate').value = customerData.email;
    //         document.getElementById('customerMobileUpdate').value = customerData.mobile;
    //         openModal('update-modal');
    //     } catch (error) {
    //         console.error('Error fetching customer data:', error);
    //         // Handle error appropriately
    //     } finally {
    //         hideLoader();
    //     }
    // }
    


    async function updateCustomer() {
        const customerName = document.getElementById('customerNameUpdate').value;
        const customerEmail = document.getElementById('customerEmailUpdate').value;
        const customerMobile = document.getElementById('customerMobileUpdate').value;
        const customerID = document.getElementById('customerID').value;

        if (!customerName || !customerEmail || !customerMobile) {
            alert("All fields are required!");
            return;
        }

        try {
            closeModal('update-modal');
            showLoader();
            
            await axios.put(`/customers/${customerID}`, {
                    name: customerName,
                    email: customerEmail,
                    mobile: customerMobile
                })
                .then(function(response) {
                    if(response.status === 200){
                        document.getElementById("customer-form").reset();
                        getList(current_page);                        
                    }
                })
                .catch(function(error) {
                    alert("Request failed!");
                });
        } catch (error) {
            console.error('Error updating customer:', error);
            // Handle error appropriately
        } finally {
            hideLoader();
        }
    }

</script>
