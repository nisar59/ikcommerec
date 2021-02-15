/*Success Message*/
function success_alert(message, reload = false)
{
    let timerInterval;
    Swal.fire({
        title: 'Success!',
        html: message,
        type: 'success',
        timer: 5000,
        onClose: () => {
            clearInterval(timerInterval);
            if (reload){
                location.reload(true);
            }
        }
    }).then((result) => {

    });
}
/*Error Message*/
function error_alert(message)
{
    let timerInterval;
    Swal.fire({
        title: "Oops...",
        html: message,
        type: "warning",
        timer: 5000,
        onClose: () => {
            clearInterval(timerInterval);
        }
    }).then((result) => {

    });
}