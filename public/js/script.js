window.addEventListener("load", function (event) {
    const form = document.getElementById('form');
    form.addEventListener('submit', function (e) {

        function createElementFromHTML(htmlString) {
            let div = document.createElement('div');
            div.innerHTML = htmlString.trim();
            return div.firstChild;
        }

        function genHtml(name, email, body) {
            return `<div class="guest"><h1>${name}</h1><strong>${email}</strong><p>${body}</p></div>`;
        }

        e.preventDefault();
        const payload = new FormData(form);

        fetch('/guests/add', {
            method: 'POST',
            body: payload,
        })
            .then((resp) => resp.json())
            .then((d) => {
                if (d.success === true) {
                    let m = createElementFromHTML(genHtml(d.data.name, d.data.email, d.data.body));
                    let guestsList = document.getElementsByClassName('guestsList')[0];
                    guestsList.insertBefore(m, guestsList.firstChild);
                } else {
                    alert(d.msg);
                }
            });
    });
});