
// toggle side bar
document.querySelector(".sideBar-toggle").addEventListener("click",()=>{
    document.getElementById("sidebar").classList.toggle("hidden");
})


// new account model
function openNewAccountModal() {
    document.getElementById('newAccountModal').classList.remove('hidden');
}

function closeNewAccountModal() {
    document.getElementById('newAccountModal').classList.add('hidden');
    document.getElementById('newAccountForm').reset();
}
// edit account model
function editAccountModal() {
    document.getElementById('editAccountModal').classList.remove('hidden');
}

function closeEditAccountModal() {
    document.getElementById('editAccountModal').classList.add('hidden');
    document.getElementById('editAccountForm').reset();
}
// edit user infos

let allUsers = document.querySelectorAll(".edit-user");
let allTr = document.querySelectorAll(".users");
allUsers.forEach((user,i) =>{
    user.addEventListener("click",()=>{
        let name = allTr[i].querySelector(".name").textContent;
        let email = allTr[i].querySelector(".email").textContent;
        let acctype = allTr[i].querySelector(".acctype").textContent;
        console.log(name, email, acctype);
        let userId = user.parentNode.parentNode.querySelector("div[data-id]").getAttribute("data-id");
        document.querySelector(".input-id").value =userId;
        document.querySelector(".cname").value =name;
        document.querySelector(".cemail").value =email;
        document.querySelector(".cacctype").value =acctype;
    })
})

// live search ajax
let searchInput = document.querySelector(".searchInput");
const oldData = document.querySelector(".tableData").innerHTML;
let toChange = document.querySelector(".tableData");
searchInput.addEventListener("keyup",()=>{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState === 4 && this.status == 200){
                let data = JSON.parse(this.responseText);
                toChange.innerHTML = "";
                console.log(data);
                if (document.querySelector(".status")){

                    document.querySelector(".status").remove();
                }
            data.forEach((s,i)=>{
                toChange.innerHTML += `
                     <tr class="users">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div>
                        <div class="text-sm font-medium text-gray-900 name" data-id="${s.id}">${s.client_name}</div>
                        <div class="text-sm text-gray-500 email">${s.email}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 acctype">${s.acc_type}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 ">${s.balance}</div>
            </td>
           
            <td class="px-6 py-6 whitespace-nowrap text-sm gap-3 flex font-medium">
                
                   
               
                <form action="adminDash.php" method="get" class="mb-0">
                    <input type="text" name="deleteUserId" value="${s.id}" class="hidden">
                    <input type="submit" value="Remove" name="deleteAcc" class="text-rose-600 hover:text-rose-900 cursor-pointer">
                </form>
            </td>
        </tr>
                `
            })
           
        }
    }
    xmlhttp.open("GET","../admin/liveSearch.php?search="+searchInput.value);
    xmlhttp.send();
})