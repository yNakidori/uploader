<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagens</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="upload-container">
        <h1>Upload de Imagens e Vídeos</h1>
        <div class="form-group">
            <label for="file">Escolha um arquivo</label>
            <input type="file" id="file" name="file" accept="image/*,video/*" multiple required>
        </div>
        <div class="form-group">
            <input type="text" id="description" name="description" placeholder="Descrição" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary" id="uploadBtn">Upload</button>
        <div class="upload-list mt-4" id="uploadList"></div>
        <div class="git">
            <h1> Veja meus outros projetos na minha página do GitHub:</h1>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchUploads();

            $('#uploadBtn').on('click', function(e) {
                e.preventDefault();
                let files = $('#file')[0].files;
                let description = $('#description').val();
                if (files.length === 0 || description === '') {
                    alert('Por favor, selecione um arquivo e insira uma descrição.');
                    return;
                }

                let formData = new FormData();
                $.each(files, function(i, file) {
                    formData.append('file[]', file);
                });
                formData.append('description', description);

                $.ajax({
                    url: 'upload.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        fetchUploads();
                        $('#file').val('');
                        $('#description').val('');
                    }
                });
            });

            function fetchUploads() {
                $.get('fetch_uploads.php', function(data) {
                    $('#uploadList').html(data);
                    attachDeleteHandlers();
                });
            }

            function attachDeleteHandlers() {
                $('.delete-btn').on('click', function() {
                    let filePath = $(this).data('file-path');
                    $.ajax({
                        url: 'delete.php',
                        type: 'POST',
                        data: {
                            file_path: filePath
                        },
                        success: function(data) {
                            fetchUploads();
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>