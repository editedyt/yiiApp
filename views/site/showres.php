<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<section class="polling-unit-result pur">
  
    <p class="cap">Select Local Government Area to display it's Polling Result</p>
    <div class="forms">
        <?php $form = ActiveForm::begin(['id' => 'form-order-article form', 'class' => 'forms', 'enableClientValidation' => true, 'enableAjaxValidation' => false,

        'action' => ['/site/showlga'],

        'options' => ['enctype' => 'multipart/form-data']]); ?>
            <select name="select" id="select">
                <option value="1" disabled selected>Select LGA</option>
            </select>
            <?= Html::submitButton('Search') ?>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="scroll tbcontainer second">
        <table class="table pu-result">   
            <p class="cap">
                Result of Polling Unit Form  Individual Local Government Area
            </p>
            <thead>
                <tr class="table_r">
                    <th class="table_h" scope="col">
                        Party
                    </th>
                    <th class="table_h" scope="col">
                        Total Party Score
                    </th>
                    <th class="table_h" scope="col">
                        Local Government Area
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                
            </tbody>
            <tbody class="hide sec">
                
            </tbody>
        </table>
    </div>
</section>

<script>
const getLga = async () => {
    await fetch('http://localhost:8080/site/cates')
    .then(response =>  response.json())
    .then(response => {  
       if(response){
        const datas = response;
        datas.map((data, i) => {
            let opt = document.createElement("option");
            opt.value = data.lga_id;
            opt.innerHTML = data.lga_name;
            return select.append(opt);
        })
       } else {
        console.log("There was an error");
       }
       
    }).catch(error => console.log(error));
}
getLga();

window.onload = function(){
    $('form').on('submit', function(e){

        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: formData,
            success: function (data) {
                const select = $("#select");
                let output = [];
                let e = $("#select")[0];
                let tb_body = document.querySelector(".pu-result tbody")
                let text = e.options[e.selectedIndex].text;
                if(data.length > 0) {
                    const in_data = [];
                    data.forEach(datas =>{
                        const info =  {
                            party: `${datas['party_abbreviation']}`,
                            value: `${datas['party_score']}` * 1
                            
                        };
                        return in_data.push(info);
                        
                    })

                    const res = Array.from(in_data.reduce((acc, {value, ...r}) => {
                        const key = JSON.stringify(r);
                        const current = acc.get(key) || {...r, value: 0};  
                        return acc.set(key, {...current, value: current.value + value});
                    }, new Map).values());

                    res.map(re => {
                        let oup = `
                        <tr id="id">
                            <td>${re.party}</td>
                            <td>${re.value}</td>
                            <td>${text}</td>
                        </tr>
                        `;
                        output.push(oup)
                    })
                    output = output.join("");
                    tb_body.innerHTML = output;  
                    $('form')[0].reset();
                }else {
                    $(tb_body).html(`
                        <tr class="pu-error">
                            <td colspan="3">No polling Unit result for this Local Government Area</td>
                        </tr>
                    `);
                }
            },
            error: function (err) {
                console.log("err");
                throw err;
            }
        });

    });
}

</script>