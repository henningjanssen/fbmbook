import datetime
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
import numpy as np

import sqlite3

con = sqlite3.connect("data/db.sqlite")
def query(sql, params=[]):
    cur = con.cursor()
    res = cur.execute(sql, params)
    return res.fetchall()

def draw():
    users = query("SELECT DISTINCT(author) FROM chat_message")
    users = list(map(lambda x: x[0], users))
    dates = query("SELECT DISTINCT(strftime('%Y-%m', m.datetime)) FROM chat_message m ORDER BY m.datetime")

    fig, ax = plt.subplots(len(users), figsize=[10,40])
    for i in range(len(users)):
        user = users[i]
        all = dict(query("SELECT strftime('%Y-%m', m.datetime), COUNT(*) FROM chat_message m WHERE m.author=:user GROUP BY strftime('%Y-%m', m.datetime);", {"user": user}))
        ax[i].fill_between(list(map(lambda x: x[0], dates)), np.zeros(len(dates)), list(map(lambda x: all.get(x[0]) or 0, dates)), alpha=0.5)

        ax[i].set(xticks=[1, len(dates)/2, len(dates)])
        ax[i].set_title(user)

    plt.tight_layout()
    #plt.axis('off')
    plt.suptitle("Nachrichtenanzahl")
    plt.savefig("trends.png")

draw()
