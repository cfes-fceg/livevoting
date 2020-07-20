import React, {useState} from 'react';
import {BALLOT_OPTIONS, VoteButton} from './vote-button';

function Ballot({className, engSocs, question}) {
    const [error, setError] = useState("");
    const [votes, setVotes] = useState([]);

    const [votingEnabled, setVotingEnabled] = useState(true);

    return (
        <div className={className}>
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
                            <div className="row">
                                <div className="col-5">
                                    {engSoc.name}
                                </div>
                                <div className="col-7">
                                    <VoteButton value={votes[engSoc.id]}
                                                disabled={!votingEnabled}
                                                rootClass={"float-right"}/>
                                </div>
                            </div>
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
    );
}

export {Ballot, BALLOT_OPTIONS}
