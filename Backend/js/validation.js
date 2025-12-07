const validation = new JustValidate("#signup");

validation
  .addField("#name", [
    {
      rule: "required",
      value: true,
      errorMessage: "El nombre es requerido"
    }
  ])
  .addField("#email", [
  { rule: "required", errorMessage: "El correo es requerido" },
  { rule: "email", errorMessage: "Correo inválido" },
  {
    validator: (value) => {
      return fetch("validate-email.php?email=" + encodeURIComponent(value))
        .then(response => response.json())
        .then(json => json.available);
    },
    errorMessage: "El correo electrónico ya está en uso"
  }
  ])
  .addField("#password", [
    {
      rule: "required",
      errorMessage: "La contraseña es requerida"
    },
    {
      rule: "minLength",
      value: 8,
      errorMessage: "La contraseña debe tener al menos 8 caracteres"
    }
  ])
  .addField("#password_confirmation", [
    {
      rule: "required",
      errorMessage: "Confirma tu contraseña"
    },
    {
      validator: (value, fields) => {
        return value === document.querySelector("#password").value;
      },
      errorMessage: "Las contraseñas no coinciden"
    }
  ])
  .onSuccess((event) =>{
    document.getElementById("signup").submit();
  });