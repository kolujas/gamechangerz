import { InputFileMaker } from "../../../submodules/InputFileMakerJS/js/InputFileMaker.js";
import { Asset } from "../../components/Asset.js";

console.log(user);

new InputFileMaker({
    accept: ['image/png'],
    button: 'Cargar imagen',
    classes: {
    input: ['user-pic'],
    button: ['user-button', 'btn', 'btn-outline', 'btn-one', 'my-4'],
    message: ['user-msg', 'color-white']
    },
    message: 'No es una imagen válida',
    id: 'user-photo',
    name: 'user-photo'
},{
    disabled: true,
    generate: document.querySelector('.user-photo'),
    image: new Asset(user.files.hasOwnProperty('profile') ? 'storage/' + user.files.profile : "img/resources/ProfileSVG.svg").route
    
}
)

new InputFileMaker({
    accept: ['image/png'],
    button: 'Cargar imagen',
    classes: {
    input: ['user-banner'],
    button: ['user-banner', 'btn', 'btn-outline', 'btn-one', 'my-4'],
    message: ['user-msg', 'color-white']
    },
    message: 'No es una imagen válida',
    id: 'user-banner',
    name: 'user-banner'
},{
    disabled: true,
    generate: document.querySelector('.user-banner'),
    image: new Asset(user.files.hasOwnProperty('banner') ? 'storage/' + user.files.banner : "storage/web/01-banner.png").route
}
)