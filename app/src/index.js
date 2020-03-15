import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import "./index.css";
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {Home} from "./pages/Home";
import {SignUpFormContent} from "./pages/signup/SignUpFormContent";
import {SignInForm} from "./shared/components/sign-in/SignInForm";
import {SignUpForm} from "./pages/signup/SignUpForm";
import {Signup} from "./pages/signup/Signup";
import {Footer} from "./shared/components/footer/footer"
import {library} from '@fortawesome/fontawesome-svg-core';
import {faGithubAlt} from '@fortawesome/free-brands-svg-icons';
import {faEnvelope, faKey,faUser,faBirthdayCake,faBeer} from '@fortawesome/free-solid-svg-icons'

library.add(faGithubAlt, faEnvelope,faKey,faUser,faBirthdayCake,faBeer);

const Routing = () => (
	<>


		<BrowserRouter>
		<div className="sfooter-content">
			<Switch>
				<Route exact path="/" component={Home}/>
				<Route exact path="/signup" component={Signup}/>
				<Route exact path="/signin" component={SignInForm}/>
				<Route component={FourOhFour}/>

			</Switch>
		</div>
		</BrowserRouter>

	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));


// use https://github.com/rlewis2892/creepy-octo-meow-react/blob/react-hooks/app/src/index.js as reference