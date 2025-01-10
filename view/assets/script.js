
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

