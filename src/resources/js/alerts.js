import Swal from 'sweetalert2';

// Configuração global do SweetAlert2
window.Swal = Swal;
// Toast padrão (notificações pequenas)
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});
// Função helper para alertas de sucesso
window.showSuccess = (message, title = 'Sucesso!') => {
    Toast.fire({
        icon: 'success',
        title: title,
        text: message
    });
};
// Função helper para alertas de erro
window.showError = (message, title = 'Erro!') => {
    Toast.fire({
        icon: 'error',
        title: title,
        text: message
    });
};
// Função helper para confirmação
window.confirmDelete = (callback) => {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Esta ação não poderá ser revertida!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
};
