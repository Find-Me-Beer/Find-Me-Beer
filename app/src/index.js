import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";

import 'bootstrap/dist/css/bootstrap.css';

import "./index.css";
import {Home} from "./pages/Home";
import {FourOhFour} from "./pages/FourOhFour";
import {applyMiddleware, createStore} from "redux";
import thunk from "redux-thunk";

const store = createStore(applyMiddleware(thunk));

const Routing = () => (
	<>
		<Provider store={store}>
		<BrowserRouter>
			<Switch>
				<Route exact path="./pages/home" component={Home}/>
				<Route component={FourOhFour}/>
			</Switch>
		</BrowserRouter>
		</Provider>
	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));


// use https://github.com/rlewis2892/creepy-octo-meow-react/blob/react-hooks/app/src/index.js as reference
