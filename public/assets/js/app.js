let indexProfs = 0;

const addProf = () => {
    $('#fieldset').append(document.getElementById('newProf').dataset.prototype.replace(/__name__/g, indexProfs));
    indexProfs++;
};

$(document).ready(() => {
    addProf();
});