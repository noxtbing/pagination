<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<input type="text" id="search-field">
<table id="miTabla">
    <thead>
    <th>
    <td>Nombre</td>
    <td>Apellido</td>
    <td>Telefono</td>
    </th>
    </thead>
    <tbody id="table-body">
    <div class="loading" style="display: none;">Cargando...</div>
    <div id="messageDataTable"></div>
    </tbody>
    <tfoot>
    <tr id="pagination-container">
        <button id="previous-button">Anterior</button>
        <button id="next-button">Siguiente</button>
    </tr>
<tr>
    <td id="page-buttons-container"></td>
</tr>
    </tfoot>
</table>
<button class="data">Data</button>
<script>

//     document.addEventListener("DOMContentLoaded", function(){
//
//             let loading = document.querySelector('.loading');
//         let totalPages;
//         let data
//         loading.style.display = 'block';
//         function createPaginationButtons(totalPages) {
//             let pageButtonsContainer = document.getElementById("page-buttons-container");
//             while (pageButtonsContainer.firstChild) {
//                 pageButtonsContainer.removeChild(pageButtonsContainer.firstChild);
//             }
//             for (let i = 1; i <= totalPages; i++) {
//                 let button = document.createElement("button");
//                 button.innerHTML = i;
//                 button.addEventListener("click", function() {
//                     currentPage = i;
//                     updateTable();
//                 });
//                 pageButtonsContainer.appendChild(button);
//             }
//         }
//             async function getData() {
//                 let response = await fetch('roles.php');
//                 let responseData = await response.json();
//                 return responseData;
//             }
// // Utilizar una función de devolución de llamada para manejar la creación de la tabla y la paginación
//         getData().then(responseData => {
//             data = responseData;
//             loading.style.display = 'none';
//             updateTable();
//         });
//
//         let currentPage = 1;
//         let rowsPerPage = 2;
//
//         let paginationContainer = document.getElementById("pagination-container");
//         let previousButton = document.getElementById("previous-button");
//         let nextButton = document.getElementById("next-button");
//
//         function updateTable() {
//             let startIndex = (currentPage - 1) * rowsPerPage;
//             let endIndex = Math.min(startIndex + rowsPerPage, data.length);
//
//             let pageData = data.slice(startIndex, endIndex);
//
//             let tableBody = document.getElementById("table-body");
//             tableBody.innerHTML = "";
//
//             // Utilizar un ciclo "for of" en lugar de un ciclo "for"
//             pageData.forEach(function(row) {
//                 let tr = document.createElement("tr");
//                 tr.innerHTML = `<td>${row.roleId}</td><td>${row.roleName}</td><td>${row.roleDescription}</td>`;
//                 tableBody.appendChild(tr);
//             });
//
//
//             totalPages = Math.ceil(data.length / rowsPerPage);
//             paginationContainer.innerHTML = `Página ${currentPage} de ${totalPages}`;
//
//             createPaginationButtons(totalPages);
//
//             if (currentPage == 1) {
//                 previousButton.disabled = true;
//             } else {
//                 previousButton.disabled = false;
//             }
//             if (currentPage == totalPages) {
//                 nextButton.disabled = true;
//             } else {
//                 nextButton.disabled = false;
//             }
//         }
//
// // Utilizar un controlador de eventos para manejar los eventos
//
//
//         document.addEventListener("click", (event) => {
//             if (event.target.id === "previous-button" && currentPage > 1) {
//                 currentPage--;
//                 updateTable();
//             }
//             if (event.target.id === "next-button" && currentPage < totalPages) {
//                 currentPage++;
//                 updateTable();
//             }
//         });
//
//
//     });

    class Pagination {
        constructor(data, rowsPerPage) {
            this.originalData = data;
            this.data = data;
            this.rowsPerPage = rowsPerPage;
            this.currentPage = 1;
            this.totalPages = 0;
            this.loading = document.querySelector('.loading');
            this.paginationContainer = document.getElementById("pagination-container");
            this.previousButton = document.getElementById("previous-button");
            this.nextButton = document.getElementById("next-button");
            this.message = document.getElementById("messageDataTable");
            this.searchField = document.getElementById("search-field");
            this.buttons = document.getElementById("page-buttons-container");
            this.filteredData = data;
        }
            handlePaginationClick(){
                this.previousButton.addEventListener("click", () => {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.updateTable();
                    }
                });
                this.nextButton.addEventListener("click", () => {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                        this.updateTable();
                    }
                });
            }


        handleSearch() {
            const searchField = document.getElementById("search-field");
            searchField.addEventListener("input", event => {
                const searchValue = event.target.value.toLowerCase();
                this.filteredData = this.data.filter(row => {
                    return row.roleName.toLowerCase().includes(searchValue) || row.roleDescription.toLowerCase().includes(searchValue);
                });
                if (searchValue === "" || this.data.length === 0) {
                    this.data = this.originalData;
                    this.currentPage = 1;
                    this.updateTable();
                } else if(this.filteredData.length === 0) {
                    this.message.textContent = "No hay datos";

                    let tableBody = document.getElementById("table-body");
                    tableBody.innerHTML = "";
                    this.paginationContainer.style.display="none"

                    this.buttons.style.display="none"
                } else {
                    this.message.textContent = "";
                    this.buttons.style.display="block"
                    this.data = this.filteredData;
                    this.currentPage = 1;
                    this.updateTable();
                }
            });
        }


        createPaginationButtons(totalPages) {
            let pageButtonsContainer = document.getElementById("page-buttons-container");
            while (pageButtonsContainer.firstChild) {
                pageButtonsContainer.removeChild(pageButtonsContainer.firstChild);
            }
            for (let i = 1; i <= totalPages; i++) {
                let button = document.createElement("button");
                button.innerHTML = i;
                button.addEventListener("click", function(){
                    this.currentPage = i;
                    this.updateTable();
                }.bind(this));

                pageButtonsContainer.appendChild(button);
            }
        }



        updateTable() {

            let startIndex = (this.currentPage - 1) * this.rowsPerPage;
            let endIndex = Math.min(startIndex + this.rowsPerPage, this.data.length);

            let pageData = this.data.slice(startIndex, endIndex);

            let tableBody = document.getElementById("table-body");
            tableBody.innerHTML = "";

            // Utilizar un ciclo "for of" en lugar de un ciclo "for"
            pageData.forEach(function(row) {
                let tr = document.createElement("tr");
                tr.innerHTML = `<td>${row.roleId}</td><td>${row.roleName}</td><td>${row.roleDescription}</td>`;
                tableBody.appendChild(tr);
            });


            this.totalPages = Math.ceil(this.data.length / this.rowsPerPage);
            this.paginationContainer.innerHTML = `Página ${this.currentPage} de ${this.totalPages}`;


            this.createPaginationButtons(this.totalPages);

            if (this.currentPage == 1) {
                this.previousButton.disabled = true;
            } else {
                this.previousButton.disabled = false;
            }
            if (this.currentPage == this.totalPages) {
                this.nextButton.disabled = true;
            } else {
                this.nextButton.disabled = false;
            }
        }


        // Método para inicializar la clase
        init() {
            this.createPaginationButtons();
            this.updateTable();
            this.handlePaginationClick();
            this.handleSearch()

            this.loading.style.display = 'none';
        }
    }

document.addEventListener("DOMContentLoaded", function(){

    async function getData() {
        let response = await fetch('roles.php');
        let responseData = await response.json();
        return responseData;
    }

    getData().then(data => {
        let pagination = new Pagination(data, 4);
        pagination.loading.style.display = 'block';
        pagination.handleSearch();
        pagination.init();
    });
});


</script>

</body>
</html>