<?php

require_once "utils/Constants.php"

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="assets/globalStyle.css">
</head>
<body>

<div id="userArea" class="container">
    <h3 class="headline">Benutzerdaten</h3>
    <img id="profilImage" alt="no image found" class="image">
    <div class="content">
        <p id="username"></p>
        <p id="bio"></p>
        <p id="creation"></p>
    </div>
</div>

<h3><?php if (!isset($_GET['repo'])) echo "Alle Projekte (<span id='repoCount'></span>)"; ?></h3>
<ul id="repos">

</ul>
<?php

if (isset($_GET['repo'])) {
    $repoName = $_GET['repo'];
    $requestUrl = "https://api.github.com/repos/" . $username . "/" . $repoName;
    echo "<script>
        let userArea = document.getElementById('userArea');
        userArea.style.display = 'none';
        
        let request = new XMLHttpRequest();
        request.open('GET', '" . $requestUrl . "');
        request.send();
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                let doc = document.getElementById('repos');
                let item = JSON.parse(request.response);
                let li1 = document.createElement('li');
                let li2 = document.createElement('li');
                let li3 = document.createElement('li');
                let li4 = document.createElement('li');
                let li5 = document.createElement('li');
                let li6 = document.createElement('li');
                li1.innerText = 'URL: ' + item.html_url;
                li2.innerText = 'Description: ' + item.description;
                li3.innerText = 'Erstellt am ' + item.created_at;
                li4.innerText = 'Letzte Aktivität am ' + item.pushed_at;
                li5.innerText = 'Erstellt am ' + item.created_at;
                li6.innerText = 'Offene Issues ' + item.open_issues_count;
                if(item.fork === false){
                    let li7 = document.createElement('li');
                    li7.innerText = 'Forks: ' + item.forks_count;
                    doc.appendChild(li7);
                }
                doc.appendChild(li1);
                doc.appendChild(li2);
                doc.appendChild(li3);
                doc.appendChild(li4);
                doc.appendChild(li5);
            }
        }
        
        let branches = new XMLHttpRequest();
        branches.open('GET', 'https://api.github.com/repos/" . $username . "/" . $repoName . "/branches');
        branches.send();
        branches.onreadystatechange = () => {
            if (branches.readyState === 4 && branches.status === 200) {
                let doc = document.getElementById('repos');
                let branchCount = 0;
                let item = JSON.parse(branches.response).forEach(branches => {
                    branchCount++;
                })
                console.log(item)
                let li1 = document.createElement('li');            
                li1.innerText = 'Branches: ' + branchCount;
                doc.appendChild(li1);         
            }
        }
    </script>";
} else {
    echo "<script>
        function requestUrl(url) {
            let request = new XMLHttpRequest();
            request.open('GET', url);
            request.send();
            return request;
        }
        let request = requestUrl('https://api.github.com/users/" . $username . "/repos?per_page=100');
        request.onreadystatechange = () => {
                if (request.readyState === 4 && request.status === 200) {
                    let doc = document.getElementById('repos');
                    JSON.parse(request.response).forEach(item => {
                        let li = document.createElement('li');
                        let node = document.createElement('a');
                        node.href = 'index.php?repo=' + item.name;
                        node.innerText = item.name + (item.archived === true ? ' (Archiviert)' : '') + (item.fork === true ? '(forked)' : '');
                        li.appendChild(node)
                        doc.appendChild(li)
                    })
                }
            }
            
        let userRequest = requestUrl('https://api.github.com/users/".$username."');
        userRequest.onreadystatechange = () => {
                if (userRequest.readyState === 4 && userRequest.status === 200) {
                    let item  = JSON.parse(userRequest.response);
                    document.getElementById('username').innerText = item.login + (item.name != null ? ' - ' +  item.name : '');
                    document.getElementById('profilImage').src = item.avatar_url;
                    document.getElementById('creation').innerText = 'Erstellt am ' + item.created_at;
                    document.getElementById('repoCount').innerText = item.public_repos;
                    document.getElementById('bio').innerText = item.bio;
                }
            }
    </script>";
}
?>
</body>
</html>
