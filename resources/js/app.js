import './bootstrap';

//notifications online user and offline user
Echo.private('notifications').listen('UserSessionChanged',(data)=>{
    const Notification = document.getElementById('notification');
    Notification.innerText = data.message;
    Notification.classList.remove('invisible');
    Notification.classList.remove('alert-success');
    Notification.classList.remove('alert-danger');
    Notification.classList.add('alert-' + data.type);

    setTimeout(() => {
        Notification.classList.add('invisible');
    }, 5000);
});

//all users list's online and offline
Echo.channel('users').listen('UserCreated', (e) => {
    const usersElement = document.getElementById('users');

    let element = document.createElement('li');

    element.setAttribute('id', e.user.id);
    element.innerText = e.user.name;
     usersElement.appendChild(element);

}).listen('UserUpdated', (e) => {
    const element = document.getElementById(e.user.id);
    element.innerText = e.user.name;
}).listen('UserDeleted', (e) => {
    const element = document.getElementById(e.user.id);
    element.parentNode.removeChild(element);
});

const circleElement = document.getElementById('circle');
const timerElement = document.getElementById('timer');
const winnerElement = document.getElementById('winner');
const betElement = document.getElementById('bet');
const resultElement = document.getElementById('result');

//circle game
Echo.channel('game')
    .listen('RemainingTimeChanged', (e) => {
        timerElement.innerText = e.time;

        circleElement.classList.add('refresh');

        winnerElement.classList.add('d-none');

        resultElement.innerText = '';
        resultElement.classList.remove('text-success');
        resultElement.classList.remove('text-danger');
    })
    .listen('WinnerNumberGenerated', (e) => {
        circleElement.classList.remove('refresh');

        let winner = e.number;
        winnerElement.innerText = winner;
        winnerElement.classList.remove('d-none');

        let bet = betElement[betElement.selectedIndex].innerText;

        if (bet == winner) {
            resultElement.innerText = 'You WIN';
            resultElement.classList.add('text-success');
        } else {
            resultElement.innerText = 'You LOSE';
            resultElement.classList.add('text-danger');
        }
    })

//user-list online and show messages
const UsersListElement = document.getElementById('users-list');
const MessageElement = document.getElementById('messages');

Echo.join('chat')
    .here((users)=>{
        users.forEach((user, index) => {
            let element = document.createElement('li');

            element.setAttribute('id', user.id);
            element.setAttribute('onclick', `greetUser(${user.id})`);
            element.innerText = user.name;
            UsersListElement.appendChild(element);
        });
    })
    .joining((user)=>{
        let element = document.createElement('li');

        element.setAttribute('id', user.id);
        element.setAttribute('onclick', `greetUser(${user.id})`);
        element.innerText = user.name;
        UsersListElement.appendChild(element);
    })
    .leaving((user)=>{
        const element = document.getElementById(user.id);
        element.parentNode.removeChild(element);
    })


Echo.channel('message').listen('MessageSent',(e)=>{

    let element = document.createElement('li');

    element.innerText = e.user.name + ': ' + e.message;

    MessageElement.appendChild(element);
})


//message send
const message = document.getElementById('message');
const send = document.getElementById('send');
send.addEventListener('click', (e) =>{
    e.preventDefault();
    window.axios.post('/chat/send',{
        message: message.value,
    })
    message.value = '';
})


