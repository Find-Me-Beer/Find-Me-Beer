import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import "./index.css";
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {Home} from "./pages/Home";
import {Signup} from "./pages/signup/Signup";
import {SignInForm} from "./shared/components/sign-in/SignIn";

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