<?php

/** @var yii\web\View $this */
use yii\base\Model;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Bincom Poll App';
?>

<main>
    <section class="polling-unit pu">
        <div class="scroll tbcontainer first">
            <p class="cap">
                Result For an Individual Polling Unit where polling unit unique id = 19;
            </p>
            <table class="table">   
                <thead>
                    <tr class="table_r">
                        <th class="table_h" scope="col">
                            Party
                        </th>
                        <th class="table_h" scope="col">
                            Party score
                        </th>
                        <th class="table_h" scope="col">
                            Entered by User
                        </th>
                        <th class="table_h" scope="col">
                            Date Entered
                        </th>
                        <th class="table_h" scope="col">
                            Ip_adddres
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>

            </table>
        </div>
    </section>
        
    <section class="polling-unit-result pur hide">
    </section>

    <section class="add-result ar hide">
       
    </section>
</main>

<script>
    const select = document.querySelector("#select");
const allSelect = document.querySelectorAll("select")
const form = document.querySelector("#form");
const newForm = document.querySelector("#newRes");
const pu_tb_body = document.querySelector(".polling-unit tbody");
const pur = document.querySelector(".pu-result");
const tb_head = document.querySelector(".pu-result thead");
const tb_body = document.querySelector(".pu-result tbody")
const tb_bodys = document.querySelector(".pu-result .sec")

const msgContainer = document.querySelector(".msg_container")

const showPollUnits = async () => {

    await fetch('http://localhost:8080/site/polls')
    .then(response =>  response.json())
    .then(response => {  
       if(response){
        let datas = response;
            let output = [];
            
            datas.forEach((data, i) => {         
                let oup = `
                <tr id=${data.polling_unit_uniqueid}>
                <td>${data.party_abbreviation}</td>
                <td>${data.party_score}</td>
                <td>${data.entered_by_user}</td>
                <td>${data.date_entered}</td>
                <td>${data.user_ip_address}</td>
                </tr>
                `;
                output.push(oup)
            })
            output = output.join(" ");
            pu_tb_body.innerHTML = output;
       } else {
        console.log("There was an error");
       }
       
    }).catch(error => console.log(error));
}


showPollUnits();
</script>