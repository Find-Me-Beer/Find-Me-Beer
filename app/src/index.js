
import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import "./index.css"

import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";


import {FourOhFour} from "./pages/FourOhFour";
import {Home} from "./pages/Home";
import {Beer} from "./pages/beer/Beer";

import {applyMiddleware, createStore} from "redux";
import {combinedReducers} from "./shared/reducers/";
import thunk from "redux-thunk";
import { Provider } from 'react-redux'

import {SignUpFormContent} from "./pages/signup/SignUpFormContent";
import {SignInForm} from "./shared/components/sign-in/SignInForm";
import {SignUpForm} from "./pages/signup/SignUpForm";
import {SignInModal} from "./shared/components/sign-in/SigninModal";
import {SignUpModal} from "./pages/signup/SignUpModal";
import {Signup} from "./pages/signup/Signup";
import {SignUpSuccess} from "./pages/SignUpSuccess";
import {Footer} from "./shared/components/footer/footer"
import {library} from '@fortawesome/fontawesome-svg-core';
import {faGithubAlt} from '@fortawesome/free-brands-svg-icons';
import {faEnvelope, faKey,faUser,faBirthdayCake,faBeer} from '@fortawesome/free-solid-svg-icons'
import axios from "axios";
import {NavBar} from "./shared/components/navbar/navbar";

import {far} from "@fortawesome/free-regular-svg-icons";
import {
	fas,
	faCat,
	faEllipsisH,
	faHeart,
	faPencilAlt,
	faSignInAlt,
	faSignOutAlt,
	faTrash,
} from "@fortawesome/free-solid-svg-icons";
library.add(far, fas, faCat, faEllipsisH, faEnvelope, faHeart, faKey, faPencilAlt, faSignInAlt, faSignOutAlt, faTrash, faUser);

library.add(faGithubAlt, faEnvelope,faKey,faUser,faBirthdayCake,faBeer);
axios.get("/apis/xsrf/");

const store = createStore(combinedReducers, applyMiddleware(thunk));

const Routing = (store) => (
	<>

		<Provider store={store}>
			<BrowserRouter>
			<div className="sfooter-content">
				<NavBar/>
				<Switch>
					<Route exact path="/" component={Home}/>
					<Route exact path="/signup" component={Signup}/>
					<Route exact path="/sign-up-successful" component={SignUpSuccess}/>
					<Route exact path="/signin" component={SignInForm}/>
					<Route exact path="/beer" component={Beer}/>
					<Route component={FourOhFour}/>
				</Switch>
				<Footer className="mt-2"/>
			</div>
			</BrowserRouter>
		</Provider>
	</>
);
ReactDOM.render(Routing(store), document.querySelector('#root'));

// use https://github.com/rlewis2892/creepy-octo-meow-react/blob/react-hooks/app/src/index.js as reference

