import Asset from "../components/Asset.js";

new window.inputfile({
    id: 'banner',
    message: 'Elige una imagen',
    button: '',
    name: 'image',
    accept: ['image/jpeg', 'image/png'],
    classes: {
        input: ['form-input'],
        message: ['russo'],
    },
}, {
    generate: document.querySelector('header.image .background'),
    image: new Asset("img/01-background.png").route,
});