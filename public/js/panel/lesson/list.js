import Activity from "../../components/Activity.js";

Activity.setModalJS();

for (const btn of document.querySelectorAll("#lessons tr .btn")) {
    btn.addEventListener("click", function (e) {
        e.stopPropagation();
        modals.activity.open({
            id_lesson: this.dataset.id_lesson,
        });
    });
}