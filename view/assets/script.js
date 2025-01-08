
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
allUsers.forEach(user =>{
    user.addEventListener("click",()=>{
        let userId = user.parentNode.parentNode.querySelector("div[data-id]").getAttribute("data-id");
        document.querySelector(".input-id").value =userId;
    })
})

