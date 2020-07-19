import React, {useEffect, useState} from 'react';
import ReactDOM from 'react-dom';
import {BALLOT_OPTIONS, VoteButton} from './vote-button';
import axios from 'axios';

function Ballot({dataString, classes}) {
    const [question, setQuestion] = useState({});
    const [engSocs, setEngSocs] = useState([]);
    const [error, setError] = useState("");

    const [votingEnabled, setVotingEnabled] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            try {
                // let data = JSON.parse(dataString)
                // setQuestion({
                //     id: data.id,
                //     title: data.title,
                // })
                axios.get('/api/user').then(response => {
                    console.log("response", response);
                }).catch(error => {
                    console.log("error", error);
                });

                let question = {
                    id: 69,
                    title: 'How do you vote on the current motion?'
                };
                setQuestion(question);
                let response = [
                    {
                        name: "Canadian Federation of Engineering Students",
                        id: 1
                    },
                    {
                        name: "York University",
                        id: 2
                    },
                    {
                        name: "Université de Québéc à Rimouski",
                        id: 3
                    },
                ];
                response = response.map(engSoc => {
                    engSoc.vote = BALLOT_OPTIONS.UNSET;
                    return engSoc;
                });
                setEngSocs(response);
            } catch (e) {
                setError(e)
            }
        }
        fetchData().then();


    }, [])

    return (
        <div className={classes}>
            <div className="row justify-content-center">
                <div className="col-md-10">
                    {error &&
                    <div className="card">
                        <div className="card-header">Error</div>

                        <div className="card-body">{error}</div>
                    </div>
                    }
                    {!error &&
                    <div className="card">
                        <div className="card-header">Vote #{question.id}: {question.title}</div>

                        <ul className="list-group list-group-flush">
                            {engSocs.map((engSoc, index) => {
                                return <li key={index} className="list-group-item">
                                    {engSoc.name}
                                    <VoteButton value={engSoc.vote}
                                                disabled={!votingEnabled}
                                                rootClass={"float-right"}/>
                                </li>
                            })}

                        </ul>
                        {votingEnabled &&
                        <div className="card-body">
                            <button className={"btn float-right btn-primary"}>
                                {engSocs.length > 1 ? 'Cast votes' : 'Cast vote'}
                            </button>
                        </div>
                        }
                    </div>
                    }
                </div>
            </div>
        </div>
    );
}

export default Ballot;

if (document.getElementById('voter-panel')) {
    let domObj = document.getElementById('voter-panel');
    let data = domObj.getAttribute('data');
    let classes = domObj.getAttribute('class');
    ReactDOM.render(<Ballot dataString={data} classes={classes}/>, document.getElementById('voter-panel'));
}
