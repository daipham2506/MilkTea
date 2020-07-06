function readImageURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById("avatar-preview").src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function readImagePostURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById("post-preview").src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function readImageProductURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("image-preview").src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
