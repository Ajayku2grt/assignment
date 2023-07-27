<!DOCTYPE html>
<html>
<head>
    <title>Product Form</title>
    <style>
        /* Add your CSS styles here */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
  <div class="container">
  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
    </div>
  @endif
  @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
    </div>
  @endif
    <h2>User Information</h2>
    <form id="userForm"  action="{{url('store-form')}}" method="post">
      @csrf
      @method('POST')

        <label for="name">Name:</label>
        <input type="text"  class="form-control" id="name" name="name" required>

        <label for="username">Username:</label>
        <input type="text"   class="form-control"id="username" name="username" required>

        <label for="phone">Phone Number:</label>
        <input type="tel"  class="form-control" id="phone" name="phone" required>

        <label for="email">Email Address:</label>
        <input type="email"  class="form-control" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password"  class="form-control" id="password" name="password" required>

        <h2>Product Information</h2>
        <table id="productsTable">
            <tr>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Quantity</th>
                <th>Product Type</th>
                <th>Discount</th>
            </tr>
            <tr>
                <td><input type="text" class="form-control"  name="product_name[]" required></td>
                <td><input type="number" class="form-control"  name="product_price[]" required></td>
                <td><input type="number" class="form-control"  name="product_quantity[]" required></td>
                <td>
                    <select class="form-control"  name="product_type[]" onchange="toggleDiscount(this)">
                        <option value="flat">Flat</option>
                        <option value="discount">Discount</option>
                    </select>
                </td>
                <td><input type="text" class="form-control"  name="discount[]" readonly></td>
            </tr>
        </table>

        <button type="button" onclick="addRow()">Add</button>

        <h2>Total Amount</h2>
        <input type="text" class="form-control" id="totalAmount" readonly>

        <button type="submit">Submit</button>
        <a href="{{url('/')}}">Cancel</a>
    </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
     function calculateTotalAmount() {
    const productsTable = document.getElementById("productsTable");
    const rows = productsTable.querySelectorAll("input[name='product_price[]']");
    const quantities = productsTable.querySelectorAll("input[name='product_quantity[]']");
    const discounts = productsTable.querySelectorAll("input[name='discount[]']");
    const totalAmount = 0;

    for (let i = 0; i < rows.length; i++) {
        const price = parseFloat(rows[i].value);
        const quantity = parseInt(quantities[i].value);
        const discount = parseFloat(discounts[i].value);

        if (discount === 0) {
            totalAmount += price * quantity;
        } else {
            totalAmount += price * quantity * (1 - discount / 100);
        }
    }

    document.getElementById("totalAmount").value = totalAmount;
}

// Add an event listener to the quantity and price inputs to trigger the calculation
rows.forEach(row => row.addEventListener("change", calculateTotalAmount));
quantities.forEach(quantity => quantity.addEventListener("change", calculateTotalAmount));


    function toggleDiscount(selectElement) {
        const discountInput = selectElement.parentElement.nextElementSibling.querySelector('input[name="discount[]"]');
        if (selectElement.value === "discount") {
            discountInput.removeAttribute("readonly");
        } else {
            discountInput.setAttribute("readonly", true);
            discountInput.value = '';
        }

        calculateTotalAmount(); // Recalculate total amount after changing the discount option.
    }

    function addRow() {
        const table = document.getElementById("productsTable");
        const newRow = table.insertRow(table.rows.length - 1);
        const columns = ["product_name", "product_price", "product_quantity", "product_type", "discount"];

        for (let i = 0; i < columns.length; i++) {
            const cell = newRow.insertCell(i);
            if (columns[i] === "product_type") {
                cell.innerHTML = `
                    <select class="form-control" name="${columns[i]}[]" onchange="toggleDiscount(this)">
                        <option value="flat">Flat</option>
                        <option value="discount">Discount</option>
                    </select>`;
            } else if (columns[i] === "discount") {
                cell.innerHTML = `<input type="text" class="form-control" name="${columns[i]}[]" readonly>`;
            } else {
                cell.innerHTML = `<input type="text" class="form-control" name="${columns[i]}[]" required>`;
            }
        }
    }
    </script>
</body>
</html>
