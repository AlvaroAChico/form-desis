document.addEventListener("DOMContentLoaded", () => {
  loadWineries();
  loadCurrencies();
  loadMaterials();
  document.getElementById("winery").addEventListener("change", loadBranches);
  document
    .getElementById("productForm")
    .addEventListener("submit", validateForm);
});

function loadWineries() {
  $.ajax({
    url: "core.php",
    method: "GET",
    data: { action: "getWineries" },
    dataType: "json",
    success: function (data) {
      var winerySelect = $("#winery");
      winerySelect.empty();
      winerySelect.append('<option value="">Seleccione una Bodega</option>');
      $.each(data, function (index, winery) {
        winerySelect.append(
          '<option value="' +
            winery.wineryId +
            '">' +
            winery.wineryName +
            "</option>"
        );
      });
    },
    error: function (error) {
      console.log("Error loading wineries:", error);
    },
  });
}

function loadCurrencies() {
  $.ajax({
    url: "core.php",
    method: "GET",
    data: { action: "getCurrencies" },
    dataType: "json",
    success: function (data) {
      var currencySelect = $("#currency");
      currencySelect.empty();
      currencySelect.append('<option value="">Seleccione una Moneda</option>');
      $.each(data, function (index, currency) {
        currencySelect.append(
          '<option value="' +
            currency.currencyId +
            '">' +
            currency.currencyName +
            "</option>"
        );
      });
    },
    error: function (error) {
      console.log("Error loading currencies:", error);
    },
  });
}

function loadBranches() {
  const wineryId = this.value;
  $.ajax({
    url: "core.php",
    method: "GET",
    data: {
      action: "getBranches",
      wineryId: wineryId,
    },
    dataType: "json",
    success: function (data) {
      var branchSelect = $("#branch");
      branchSelect.empty();
      branchSelect.append('<option value="">Seleccione una Sucursal</option>');
      $.each(data, function (index, branch) {
        branchSelect.append(
          '<option value="' +
            branch.branchId +
            '">' +
            branch.branchName +
            "</option>"
        );
      });
    },
    error: function (error) {
      console.log("Error loading branches:", error);
    },
  });
}

function loadMaterials() {
  $.ajax({
    url: "core.php",
    method: "GET",
    data: { action: "getMaterials" },
    dataType: "json",
    success: function (data) {
      var materialsContainer = $("#materials");
      materialsContainer.empty();
      $.each(data, function (index, material) {
        materialsContainer.append(
          `<div>
            <input type="checkbox" name="material" value="${material.material_id}" class="form-container__checkbox">
            <label>${material.material_name}</label>
          </div>`
        );
      });
    },
    error: function (error) {
      console.log("Error loading materials:", error);
    },
  });
}

async function validateForm(event) {
  event.preventDefault();

  const code = document.getElementById("code").value;
  const name = document.getElementById("name").value;
  const price = document.getElementById("price").value;
  const materials = document.querySelectorAll('input[name="material"]:checked');
  const winery = document.getElementById("winery").value;
  const branch = document.getElementById("branch").value;
  const currency = document.getElementById("currency").value;
  const description = document.getElementById("description").value;

  const isCodeValid = await validateCode(code);
  if (!isCodeValid) return;

  if (!validateName(name)) return;
  if (!validatePrice(price)) return;
  if (materials.length < 2) {
    alert("Debe seleccionar al menos dos materiales para el producto.");
    return;
  }
  if (winery === "") {
    alert("Debe seleccionar una bodega.");
    return;
  }
  if (branch === "") {
    alert("Debe seleccionar una sucursal.");
    return;
  }
  if (currency === "") {
    alert("Debe seleccionar una moneda.");
    return;
  }
  if (!validateDescription(description)) return;

  const formData = new FormData();

  formData.append("code", code);
  formData.append("name", name);
  formData.append("price", price);
  formData.append("winery", winery);
  formData.append("branch", branch);
  formData.append("currency", currency);
  formData.append("description", description);
  materials.forEach((material) => {
    formData.append("materials[]", material.value);
  });

  $.ajax({
    url: "core.php?action=saveProduct",
    method: "POST",
    data: formData,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response.message) {
        alert(response.message);
      } else {
        alert("Ocurrió un error al guardar el producto.");
      }
    },
    error: function (error) {
      console.log("Error al guardar el producto:", error);
      alert("Ocurrió un error en el servidor. Intente de nuevo más tarde.");
    },
  });
}

async function validateCode(code) {
  const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/;
  if (!code) {
    alert("El código del producto no puede estar en blanco.");
    return false;
  }
  if (!regex.test(code)) {
    alert(
      "El código del producto debe contener letras y números y tener entre 5 y 15 caracteres."
    );
    return false;
  }

  const exists = await validateExistProduct(code);
  if (exists) {
    alert("El código del producto ya existe.");
    return false;
  }

  return true;
}

async function validateExistProduct(code) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "core.php",
      method: "GET",
      data: {
        action: "validateExistProduct",
        productId: code,
      },
      dataType: "json",
      success: function (data) {
        resolve(data.length > 0);
      },
      error: function (error) {
        console.log("Error validating product:", error);
        reject(error);
      },
    });
  });
}

function validateName(name) {
  if (!name) {
    alert("El nombre del producto no puede estar en blanco.");
    return false;
  }
  if (name.length < 2 || name.length > 50) {
    alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
    return false;
  }
  return true;
}

function validatePrice(price) {
  const regex = /^\d+(\.\d{1,2})?$/;
  if (!price) {
    alert("El precio del producto no puede estar en blanco.");
    return false;
  }
  if (!regex.test(price)) {
    alert(
      "El precio del producto debe ser un número positivo con hasta dos decimales."
    );
    return false;
  }
  return true;
}

function validateDescription(description) {
  if (!description) {
    alert("La descripción del producto no puede estar en blanco.");
    return false;
  }
  if (description.length < 10 || description.length > 1000) {
    alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
    return false;
  }
  return true;
}
