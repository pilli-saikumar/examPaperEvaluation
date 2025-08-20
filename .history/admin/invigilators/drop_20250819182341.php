<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Multiselect Example</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Multiselect CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
</head>
<body class="p-4">

  <div class="container">
    <h4 class="mb-3">Select Invigilators</h4>
    <form>
      <select id="example-multiselect" multiple="multiple">
        <option value="1">Invigilator 1</option>
        <option value="2">Invigilator 2</option>
        <option value="3">Invigilator 3</option>
        <option value="4">Invigilator 4</option>
        <option value="5">Invigilator 5</option>
      </select>
    </form>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Bootstrap Multiselect JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#example-multiselect').multiselect({
        buttonWidth: '300px',
        includeSelectAllOption: true,
        enableFiltering: true,
        maxHeight: 300,
        numberDisplayed: 2,
        nonSelectedText: 'Select Invigilators'
      });
    });
  </script>

</body>
</html>
