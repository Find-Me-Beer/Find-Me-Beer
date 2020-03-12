import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import "./index.css"
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";

import {FourOhFour} from "./pages/FourOhFour";
import {Home} from "./pages/Home";
import {Beer} from "./pages/beer/Beer";

import {applyMiddleware, combineReducers, createStore} from "redux";
import {reducers} from "./shared/reducers";
import thunk from "redux-thunk";
import { Provider } from 'react-redux'

const store = createStore(combineReducers, applyMiddleware(thunk));

const Routing = (store) => (
	<>
		<Provider store={store}>
			<BrowserRouter>
				<Switch>
					<Route exact path="/" component={Home}/>
					<Route exact path="/beer" component={Beer}/>
					<Route component={FourOhFour}/>
				</Switch>
			</BrowserRouter>
		</Provider>
	</>
);
ReactDOM.render(Routing(store), document.querySelector('#root'));


// use https://github.com/rlewis2892/creepy-octo-meow-react/blob/react-hooks/app/src/index.js as reference