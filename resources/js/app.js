import './bootstrap';
import Alpine from 'alpinejs';
import Inputmask from "inputmask";

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    Inputmask({
        alias: "currency",
        prefix: "R$ ",
        groupSeparator: ".",
        radixPoint: ",",
        digits: 2,
        autoUnmask: true
    }).mask("#amount");
});
