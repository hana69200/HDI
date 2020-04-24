<?php require_once(PATH_VIEWS.'header.php');?>

<!--  Zone message d'alerte -->
<?php require_once(PATH_VIEWS.'alert.php');?>

<!--  Début de la page -->

<?php
	if(!isset($alert)){ //s'il n'y a pas eu d'erreurs
?>
	
	<div class="container" id="container">
			<div class="form-container sign-in-container">
                <form method="post" action="index.php?page=inscription">
                    <h1> Creer un compte </h1>
                    <input name="nom" type="text" placeholder="Nom"/>
                    <input type="text" name="prenom" placeholder="Prénom"/>
                    <input type="password" name="pwd"placeholder="Password"/>
                    <input type="email" name="email"placeholder="Email"/>
                    
                    <button> S'inscrire </button>
                </form>

            </div>
            <div class="overlay-container">
                <div class="overlay">
					<div class="overlay-panel overlay-right">
                        <h1>Bon retour !</h1>
                        <p>Veuillez vous connecter avec vos informations personnelles</p>
                        <a href="index.php?page=connexion" class="p-0 rounded"><button class="ghost" name="valider" id="signIn"> Se connecter </button></a>
                    </div>
                    
                </div>
            </div>
        
	</div>
	
		
		<style type="text/css">
	/*@import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');*/

	* {
    box-sizing: border-box;
}

h1{
    font-weight: bold;
    margin: 0;
}
p {
    font-size: 14px;
    font-weight: 100;
    line-height: 20px;
    letter-spacing: 0.5px;
    margin: 20px 0 30px;
}

a{

    color: #333;
    font-size: 12px;
    text-decoration: none;
    margin: 15px 0;
}

.container{

    background: #fff;
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 480px;
}

.form-container form{

    background: #fff;
    display:flex;
    flex-direction: column;
    padding: 0 50px;
    height: 100%;
    justify-content: center;
    align-items: center;
    text-align: center;

}

.social-container {

    margin: 20px 0;

}

.social-container a{
    border: 1px solid #ddd;
    border-radius: 50px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 5px;
    height: 4Opx;
    width: 40px;
}

.form-container input{
    background: #eee;
    border:none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
}

button{
    border-radius: 20px;
    border: 1px solid #BB0B0B;
    background:#BB0B0B ;
    color:#fff;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing:1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
}
/*obtenir un effet sur le clique*/
button:active{
    transform: scale(0.95);
}
button:focus{
    outline: none;
}


button.ghost{
    background: transparent;
    border-color: #fff;
}
.form-container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;

}

.sign-in-container{
    left: 0;
    width: 50%;
    z-index: 2;

}

.sign-up-container{
    left: 0;
    width: 50%;
    opacity:0;
    z-index: 1;
    
}

.overlay-container {
    position:absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition:  transform 0.6s ease-in-out;
    z-index: 100;
}
.container.right-panel-active .overlay-container {
    transform: translateX(-100%);
}
.container.right-panel-active .overlay-left {
    transform: translateX(0);
}

.container.right-panel-active .overlay-right {
    transform: translateX(20%);
}


.overlay{
    background: #99182c;
    background: -webkit-linear-gradient(to right, #ff4b2b, #99182c);
    background: linear-gradient(to right, #ff4b2b, #99182c);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 0 0;
    color: #ffffff;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}
.overlay-panel {

    position: absolute;
    top:0;
    display:flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0 40px;
    height: 100%;
    width: 50%;
    text-align: center;
    transform: translateX(0);
    transition: transform 0.6 ease-in-out;
}

.overlay-right {
    right:0;
    transform: translateX(0);
}
/*Animation */


/*deplacer connecter à droite */

.container.right-panel-active.sign-in-container{
    transform: translateX(100%);
}
.container.right-panel-active .overlay {
    transform: translateX(50%);
}

@keyframes show {
    0%,
    49.99% {
        opacity: 0;
        z-index: 1;
    }

    50%,
    100% {
        opacity: 1;
        z-index: 5;
    }
}
		</style>
	<?php 
	}
	?>
