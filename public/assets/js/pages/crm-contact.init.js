function timeConvert(e){var e=new Date(e),e=(time_s=e.getHours()+":"+e.getMinutes()).split(":"),t=e[0],e=e[1],a=12<=t?"PM":"AM";return(t=(t%=12)||12)+":"+(e=e<10?"0"+e:e)+a}function formatDate(e){var e=new Date(e),t=""+["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"][e.getMonth()],a=""+e.getDate(),e=e.getFullYear();return t.length<2&&(t="0"+t),[(a=a.length<2?"0"+a:a)+" "+t,e].join(", ")}var checkAll=document.getElementById("checkAll"),perPage=(checkAll&&(checkAll.onclick=function(){for(var e=document.querySelectorAll('.form-check-all input[type="checkbox"]'),t=0;t<e.length;t++)e[t].checked=this.checked,e[t].checked?e[t].closest("tr").classList.add("table-active"):e[t].closest("tr").classList.remove("table-active")}),8),options={valueNames:["id","name","company_name","designation","date","email_id","phone","lead_score","tags"],page:perPage,pagination:!0,plugins:[ListPagination({left:2,right:2})]},contactList=new List("contactList",options).on("updated",function(e){0==e.matchingItems.length?document.getElementsByClassName("noresult")[0].style.display="block":document.getElementsByClassName("noresult")[0].style.display="none";var t=1==e.i,a=e.i>e.matchingItems.length-e.page;document.querySelector(".pagination-prev.disabled")&&document.querySelector(".pagination-prev.disabled").classList.remove("disabled"),document.querySelector(".pagination-next.disabled")&&document.querySelector(".pagination-next.disabled").classList.remove("disabled"),t&&document.querySelector(".pagination-prev").classList.add("disabled"),a&&document.querySelector(".pagination-next").classList.add("disabled"),e.matchingItems.length<=perPage?document.querySelector(".pagination-wrap").style.display="none":document.querySelector(".pagination-wrap").style.display="flex",0<e.matchingItems.length?document.getElementsByClassName("noresult")[0].style.display="none":document.getElementsByClassName("noresult")[0].style.display="block"});const xhttp=new XMLHttpRequest;xhttp.onload=function(){var e=JSON.parse(this.responseText);Array.from(e).forEach(function(e){var t=e.tags,a="";Array.from(t).forEach((e,t)=>{a+='<span class="badge badge-soft-primary me-1">'+e+"</span>"}),contactList.add({id:`<a href="javascript:void(0);" class="fw-medium link-primary">#VZ${e.id}</a>`,name:'<div class="d-flex align-items-center">            <div class="flex-shrink-0"><img src="'+e.name[0]+'" alt="" class="avatar-xs rounded-circle"></div>            <div class="flex-grow-1 ms-2 name">'+e.name[1]+"</div>            </div>",company_name:e.company_name,designation:e.designation,date:formatDate(e.date)+' <small class="text-muted">'+timeConvert(e.date)+"</small>",email_id:e.email_id,phone:e.phone,lead_score:e.lead_score,tags:a}),contactList.sort("id",{order:"desc"}),refreshCallbacks()}),contactList.remove("id",'<a href="javascript:void(0);" class="fw-medium link-primary">#VZ001</a>')},xhttp.open("GET","assets/json/contact-list.json"),xhttp.send(),isCount=(new DOMParser).parseFromString(contactList.items.slice(-1)[0]._values.id,"text/html"),document.querySelector("#customer-image-input").addEventListener("change",function(){var e=document.querySelector("#customer-img"),t=document.querySelector("#customer-image-input").files[0],a=new FileReader;a.addEventListener("load",function(){e.src=a.result},!1),t&&a.readAsDataURL(t)});var idField=document.getElementById("id-field"),customerImg=document.getElementById("customer-img"),customerNameField=document.getElementById("customername-field"),company_nameField=document.getElementById("company_name-field"),designationField=document.getElementById("designation-field"),email_idField=document.getElementById("email_id-field"),phoneField=document.getElementById("phone-field"),lead_scoreField=document.getElementById("lead_score-field"),addBtn=document.getElementById("add-btn"),editBtn=document.getElementById("edit-btn"),removeBtns=document.getElementsByClassName("remove-item-btn"),editBtns=document.getElementsByClassName("edit-item-btn"),table=(viewBtns=document.getElementsByClassName("view-item-btn"),refreshCallbacks(),document.getElementById("showModal").addEventListener("show.bs.modal",function(e){e.relatedTarget.classList.contains("edit-item-btn")?(document.getElementById("exampleModalLabel").innerHTML="Edit Contact",document.getElementById("showModal").querySelector(".modal-footer").style.display="block",document.getElementById("add-btn").style.display="none",document.getElementById("edit-btn").style.display="block"):e.relatedTarget.classList.contains("add-btn")?(document.getElementById("exampleModalLabel").innerHTML="Add Contact",document.getElementById("showModal").querySelector(".modal-footer").style.display="block",document.getElementById("edit-btn").style.display="none",document.getElementById("add-btn").style.display="block"):(document.getElementById("exampleModalLabel").innerHTML="List Contact",document.getElementById("showModal").querySelector(".modal-footer").style.display="none")}),ischeckboxcheck(),document.getElementById("showModal").addEventListener("hidden.bs.modal",function(e){clearFields()}),document.querySelector("#contactList").addEventListener("click",function(){refreshCallbacks(),ischeckboxcheck()}),document.getElementById("customerTable")),tr=table.getElementsByTagName("tr"),trlist=table.querySelectorAll(".list tr"),dateValue=(new Date).toUTCString().slice(5,16);function currentTime(){var e=12<=(new Date).getHours()?"PM":"AM",t=12<(new Date).getHours()?(new Date).getHours()%12:(new Date).getHours(),a=(new Date).getMinutes()<10?"0"+(new Date).getMinutes():(new Date).getMinutes();return t<10?"0"+t+":"+a+" "+e:t+":"+a+" "+e}setInterval(currentTime,1e3);var count=11,tagInputField=new Choices("#taginput-choices",{removeItemButton:!0}),tagInputFieldValue=tagInputField.getValue(!0),tagHtmlValue="";function ischeckboxcheck(){Array.from(document.getElementsByName("checkAll")).forEach(function(e){e.addEventListener("click",function(e){e.target.checked?e.target.closest("tr").classList.add("table-active"):e.target.closest("tr").classList.remove("table-active")})})}function refreshCallbacks(){Array.from(removeBtns).forEach(function(e){e.addEventListener("click",function(e){e.target.closest("tr").children[1].innerText,itemId=e.target.closest("tr").children[1].innerText;e=contactList.get({id:itemId});Array.from(e).forEach(function(e){var t=(deleteid=(new DOMParser).parseFromString(e._values.id,"text/html")).body.firstElementChild;deleteid.body.firstElementChild.innerHTML==itemId&&document.getElementById("delete-record").addEventListener("click",function(){contactList.remove("id",t.outerHTML),document.getElementById("deleteRecord-close").click()})})})}),Array.from(editBtns).forEach(function(e){e.addEventListener("click",function(e){e.target.closest("tr").children[1].innerText,itemId=e.target.closest("tr").children[1].innerText;e=contactList.get({id:itemId});Array.from(e).forEach(function(e){var t=(isid=(new DOMParser).parseFromString(e._values.id,"text/html")).body.firstElementChild.innerHTML,a=(new DOMParser).parseFromString(e._values.tags,"text/html").body.querySelectorAll("span.badge");t==itemId&&(idField.value=t,customerImg.src=(new DOMParser).parseFromString(e._values.name,"text/html").body.querySelector("img").src,customerNameField.value=(new DOMParser).parseFromString(e._values.name,"text/html").body.querySelector(".name").innerHTML,company_nameField.value=e._values.company_name,designationField.value=e._values.designation,email_idField.value=e._values.email_id,phoneField.value=e._values.phone,lead_scoreField.value=e._values.lead_score,a&&Array.from(a).forEach(e=>{tagInputField.setChoiceByValue(e.innerHTML)}))})})}),Array.from(viewBtns).forEach(function(e){e.addEventListener("click",function(e){e.target.closest("tr").children[1].innerText,itemId=e.target.closest("tr").children[1].innerText;e=contactList.get({id:itemId});Array.from(e).forEach(function(e){(isid=(new DOMParser).parseFromString(e._values.id,"text/html")).body.firstElementChild.innerHTML==itemId&&(e=`
                        <div class="card-body text-center">
                            <div class="position-relative d-inline-block">
                                <img src="${(new DOMParser).parseFromString(e._values.name,"text/html").body.querySelector("img").src}" alt=""
                                    class="avatar-lg rounded-circle img-thumbnail object-cover">
                                <span class="contact-active position-absolute rounded-circle bg-success"><span
                                        class="visually-hidden"></span>
                            </div>
                            <h5 class="mt-4 mb-1">${(new DOMParser).parseFromString(e._values.name,"text/html").body.querySelector(".name").innerHTML}</h5>
                            <p class="text-muted">${e._values.company_name}</p>

                            <ul class="list-inline mb-0">
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-soft-success text-success fs-15 rounded">
                                        <i class="ri-phone-line"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-soft-danger text-danger fs-15 rounded">
                                        <i class="ri-mail-line"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-soft-warning text-warning fs-15 rounded">
                                        <i class="ri-question-answer-line"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Personal Information</h6>
                            <p class="text-muted mb-4">Hello, I'm Tonya Noble, The most effective objective is
                                one that is tailored to the job you are applying for. It states what kind of
                                career you are seeking, and what skills and experiences.</p>
                            <div class="table-responsive table-card">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium" scope="row">Designation</td>
                                            <td>${e._values.designation}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Email ID</td>
                                            <td>${e._values.email_id}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Phone No</td>
                                            <td>${e._values.phone}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Lead Score</td>
                                            <td>${e._values.lead_score}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Tags</td>
                                            <td>${e._values.tags}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Last Contacted</td>
                                            <td>${e._values.date} <small class="text-muted"></small></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>`,document.getElementById("contact-view-detail").innerHTML=e)})})})}function clearFields(){customerImg.src="assets/images/users/user-dummy-img.jpg",customerNameField.value="",company_nameField.value="",designationField.value="",email_idField.value="",phoneField.value="",lead_scoreField.value="",tagInputField.removeActiveItems(),tagInputField.setChoiceByValue("0")}function deleteMultiple(){ids_array=[];var e,t=document.getElementsByName("chk_child");for(i=0;i<t.length;i++)1==t[i].checked&&(e=t[i].parentNode.parentNode.parentNode.querySelector("td a").innerHTML,ids_array.push(e));"undefined"!=typeof ids_array&&0<ids_array.length?Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-primary w-xs me-2 mt-2",cancelButtonClass:"btn btn-danger w-xs mt-2",confirmButtonText:"Yes, delete it!",buttonsStyling:!1,showCloseButton:!0}).then(function(e){if(e.value){for(i=0;i<ids_array.length;i++)contactList.remove("id",`<a href="javascript:void(0);" class="fw-medium link-primary">${ids_array[i]}</a>`);document.getElementById("checkAll").checked=!1,Swal.fire({title:"Deleted!",text:"Your data has been deleted.",icon:"success",confirmButtonClass:"btn btn-info w-xs mt-2",buttonsStyling:!1})}}):Swal.fire({title:"Please select at least one checkbox",confirmButtonClass:"btn btn-info",buttonsStyling:!1,showCloseButton:!0})}Array.from(tagInputFieldValue).forEach((e,t)=>{tagHtmlValue+='<span class="badge badge-soft-primary me-1">'+e+"</span>"}),addBtn.addEventListener("click",function(e){var t,a;""!==customerNameField.value&&""!==company_nameField.value&&""!==email_idField.value&&""!==phoneField.value&&""!==lead_scoreField.value&&""!==designationField.value&&(t=tagInputField.getValue(!0),a="",Array.from(t).forEach((e,t)=>{a+='<span class="badge badge-soft-primary me-1">'+e+"</span>"}),contactList.add({id:`<a href="javascript:void(0);" class="fw-medium link-primary">#VZ${count}</a>`,name:'<div class="d-flex align-items-center">            <div class="flex-shrink-0"><img src="'+customerImg.src+'" alt="" class="avatar-xs rounded-circle object-cover"></div>            <div class="flex-grow-1 ms-2 name">'+customerNameField.value+"</div>            </div>",company_name:company_nameField.value,designation:designationField.value,email_id:email_idField.value,phone:phoneField.value,lead_score:lead_scoreField.value,tags:a,date:dateValue+' <small class="text-muted">'+currentTime()+"</small>"}),contactList.sort("id",{order:"desc"}),document.getElementById("close-modal").click(),clearFields(),refreshCallbacks(),count++,Swal.fire({position:"center",icon:"success",title:"Contact inserted successfully!",showConfirmButton:!1,timer:2e3,showCloseButton:!0}))}),editBtn.addEventListener("click",function(e){document.getElementById("exampleModalLabel").innerHTML="Edit Contact";var t=contactList.get({id:idField.value});Array.from(t).forEach(function(e){var t=(isid=(new DOMParser).parseFromString(e._values.id,"text/html")).body.firstElementChild.innerHTML,a=tagInputField.getValue(!0),n="";Array.from(a).forEach((e,t)=>{n+='<span class="badge badge-soft-primary me-1">'+e+"</span>"}),t==itemId&&e.values({id:`<a href="javascript:void(0);" class="fw-medium link-primary">#VZ${idField.value}</a>`,name:'<div class="d-flex align-items-center">                <div class="flex-shrink-0"><img src="'+customerImg.src+'" alt="" class="avatar-xs rounded-circle object-cover"></div>                <div class="flex-grow-1 ms-2 name">'+customerNameField.value+"</div>                </div>",company_name:company_nameField.value,designation:designationField.value,email_id:email_idField.value,phone:phoneField.value,lead_score:lead_scoreField.value,tags:n,date:dateValue+' <small class="text-muted">'+currentTime()+"</small>"})}),document.getElementById("close-modal").click(),clearFields(),Swal.fire({position:"center",icon:"success",title:"Contact updated Successfully!",showConfirmButton:!1,timer:2e3,showCloseButton:!0})}),document.querySelector(".pagination-next").addEventListener("click",function(){!document.querySelector(".pagination.listjs-pagination")||document.querySelector(".pagination.listjs-pagination").querySelector(".active")&&document.querySelector(".pagination.listjs-pagination").querySelector(".active").nextElementSibling.children[0].click()}),document.querySelector(".pagination-prev").addEventListener("click",function(){!document.querySelector(".pagination.listjs-pagination")||document.querySelector(".pagination.listjs-pagination").querySelector(".active")&&document.querySelector(".pagination.listjs-pagination").querySelector(".active").previousSibling.children[0].click()});