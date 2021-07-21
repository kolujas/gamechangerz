import { InputFileMaker } from "../../../submodules/InputFileMakerJS/js/InputFileMaker.js";
import { Asset } from "../../components/Asset.js";

new InputFileMaker({
    accept: ['image/png'],
    button: 'Cargar imagen',
    classes: {
    input: ['teacher-pic'],
    button: ['teacher-button', 'btn', 'btn-outline', 'btn-one', 'my-4'],
    message: ['teacher-msg', 'color-white']
    },
    message: 'No es una imagen válida',
    id: 'teacher-photo',
    name: 'teacher-photo'
},{
    disabled: true,
    generate: document.querySelector('.profile-photo'),
    image: new Asset('storage/' + user.files.profile).route
}
)

new InputFileMaker({
    accept: ['image/png'],
    button: 'Cargar imagen',
    classes: {
    input: ['teacher-banner'],
    button: ['teacher-button', 'btn', 'btn-outline', 'btn-one', 'my-4'],
    message: ['teacher-msg', 'color-white']
    },
    message: 'No es una imagen válida',
    id: 'teacher-teampro',
    name: 'teacher-teampro'
},{
    disabled: true,
    generate: document.querySelector('.teampro-photo'),
    image: new Asset('storage/' + user.files.teampro).route
}
)