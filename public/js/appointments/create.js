let $estilista, $date, $service, $iRadio; 
let $hoursMornings, $hoursAfternoon, $titleMorning, $titleAfternoon;

const titleMorning = `
    En la mañana
` ;

const titleAfternoon = `
    En la Tarde
` ;

const noHours = `
    <h5 class="text-danger">No hay horas disponibles </h5>
`;

$(function(){
    $service = $('#service');
    $estilista = $('#estilista');
    $date = $('#date');
    $titleMorning = $('#titleMorning');
    $hoursMornings = $('#hoursMornings');
    $titleAfternoon = $('#titleAfternoon');
    $hoursAfternoon = $('#hoursAfternoon');

    $service.change(() => {
        const serviceId = $service.val();
        const url = `/api/services/${serviceId}/estilistas`
        $.getJSON(url, onEstilistasLoaded);
    });
    $estilista.change(loadHours);
    $date.change(loadHours);

     
    });

function onEstilistasLoaded (estilistas){
   let htmlOptions = '';
   estilistas.forEach(estilista => {
        htmlOptions += `<option value="${estilista.id}"> ${estilista.name} </option>`;
   });
   $estilista.html(htmlOptions);

   loadHours();
}

function loadHours(){
    const selectedDate = $date.val();
    const estilistaId = $estilista.val();
    const url = `/api/horario/horas?date=${selectedDate}&estilista_id=${estilistaId}`;
    $.getJSON(url, dispplayHours);
}

function dispplayHours(data){
    console.log(data);
    let htmlHoursM = '';
    let htmlHoursA = '';

    iRadio = 0;

    if(data.morning){
        const morning_intervalos = data.morning;
        morning_intervalos.forEach(intervalo => {
            htmlHoursM += getRadioIntervaloHTML(intervalo);
        });
    }
    if(!htmlHoursM != ""){
        htmlHoursM += noHours;
    }

    if(data.afternoon){
            const afternoon_intervalos = data.afternoon;
            afternoon_intervalos.forEach(intervalo => {
                htmlHoursA += getRadioIntervaloHTML(intervalo);
        });
    }
    if(!htmlHoursA != ""){
        htmlHoursA += noHours;
    }


    $hoursMornings.html(htmlHoursM);
    $hoursAfternoon.html(htmlHoursA);
    $titleMorning.html(titleMorning);
    $titleAfternoon.html(titleAfternoon);
}


 function getRadioIntervaloHTML(intervalo){
    const text = `${intervalo.start} - ${intervalo.end}`;
    return `<div class="custom-control custom-radio mb-3">
                <input type="radio" id="interval${iRadio}" name="scheduled_time" value="${intervalo.start}" class="custom-control-input" required>
                <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
            </div>`
 }