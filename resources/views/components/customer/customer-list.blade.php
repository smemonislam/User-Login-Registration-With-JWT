<div class="container mt-4">
    <div class="row justify-content-between">
        <div class="align-customers-center col">
            <h5 class="fw-bold">Business Table</h5>
        </div>
        <div class="align-customers-center col">
            <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn  px-4 btn-success">Create
                New</button>
        </div>
    </div>
</div>
<hr />

<div class="container">
    <div class="row">
        <div class="col-md-2 px-2">
            <label>Per Page</label>
            <select id="perPage" class="form-control form-select-sm form-select">
                <option>5</option>
                <option>10</option>
                <option>15</option>
            </select>
        </div>

        <div class="col-md-2 px-2">
            <label>Search</label>
            <div class="input-group">
                <input value="" type="text" id="keyword" class="form-control form-control-sm">
                <button class="btn btn-sm btn-success" type="button" id="searchButton">Search</button>
            </div>
        </div>
    </div>
</div>
<hr />

<div class="container">
    <div class="row">
        <div class="col-md-12 p-2 col-sm-12 col-lg-12">
            <div class="shadow-sm bg-white rounded-3 p-2">
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-2 p-2">
            <div class="">
                <button onclick="handlePrevious()" id="previousButton" class="btn btn-sm btn-success">Previous</button>
                <button onclick="handleNext()" id="nextButton" class="btn btn-sm mx-1 btn-success">Next</button>
            </div>
        </div>
    </div>
</div>

<script>
    let current_page = 1;
    async function getList() {
        const per_page = document.getElementById('perPage').value;
        const keyword = document.getElementById('keyword').value;
        const response = await axios.get(`/customers?page=${current_page}&perPage=${per_page}&keyword=${keyword}`);

        updateTable(response.data);
    }

    function updateTable(data) {

        let table_list = document.getElementById('tableList');

        if (!data.data.length) {
            table_list.innerHTML = '<tr><td colspan="4" class="text-center">No customers found.</td></tr>';
            return;
        }

        let row_html = data.data.map(function(customer) {
            return `<tr>
                        <td>${customer.id}</td>
                        <td>${customer.name}</td>
                        <td>${customer.email}</td>
                        <td>${customer.mobile}</td>  
                        <td>
                            <button data-id="${customer.id}" data-bs-toggle="modal" data-bs-target="#update-modal" class="btn btn-sm editBtn btn-outline-success">Edit</button>
                            <button data-id="${customer.id}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                        </td>          
                    </tr>`
        }).join('');

        table_list.innerHTML = row_html;

    }

    document.getElementById('perPage').addEventListener('change', function() {
        current_page = 1;
        getList();
    });

    document.getElementById('keyword').addEventListener('change', function() {
        current_page = 1;
        getList();
    });


    function handlePrevious() {
        if (current_page > 1) {
            current_page--;
            getList();
        }
    }

    function handleNext() {
        current_page++;
        getList();
    }
    getList();

    document.getElementById('tableList').addEventListener('click', function(event) {
        const target = event.target;
        if (target.classList.contains('deleteBtn')) {
            const customerId = target.getAttribute('data-id');
            handleDelete(customerId);

        }
    });

    async function handleDelete(customerId) {
        await axios.delete(`/customers/${customerId}`)
            .then(function(response) {
                if (response.status == 200) {
                    alert(response.data);
                    getList(current_page);
                }
            }).catch(function(error) {
                console.log(error);
            });
    }
</script>
