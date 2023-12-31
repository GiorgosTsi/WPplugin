document.addEventListener('DOMContentLoaded', function(e) {

    let testimonialForm = document.getElementById('giorghs-testimonial-form');

    testimonialForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // reset the form messages
        resetMessages();

        // collect all the data
        let data = {
            name: testimonialForm.querySelector('[name="name"]').value,
            email: testimonialForm.querySelector('[name="email"]').value,
            message: testimonialForm.querySelector('[name="message"]').value
        }

        // validate the email
        if (! validateEmail(data.email)) {
            testimonialForm.querySelector('.email-error').classList.add('show');
            return;
        }

        if (!data.name) {
            testimonialForm.querySelector('.name-error').classList.add('show');
            return;
        }

        if (!data.message) {
            testimonialForm.querySelector('.message-error').classList.add('show');
            return;
        }

        // ajax http post request
        let url = testimonialForm.dataset.url;
        let params = new URLSearchParams(new FormData(testimonialForm));

        testimonialForm.querySelector('.js-form-submission').classList.add('show');

        fetch(url, {
            method: "POST",
            body: params,
        }).then(res => res.json())
            .catch(error => {
                resetMessages();
                testimonialForm.querySelector('.js-form-error').classList.add('show');
            })
            .then(response => {
                resetMessages();

                if (response === 0 || response.status === 'error') {
                    testimonialForm.querySelector('.js-form-error').classList.add('show');
                    return;
                }

                testimonialForm.querySelector('.js-form-success').classList.add('show');
                resetForm(testimonialForm);
            });
    });
});

    function resetMessages() {

        document.querySelectorAll('.field-msg').forEach(f => f.classList.remove('show'));
    }

    function validateEmail(email) {

        let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function resetForm(form) {
        form.querySelector('[name="name"]').value = '';
        form.querySelector('[name="email"]').value = '';
        form.querySelector('[name="message"]').value = '';
    }
