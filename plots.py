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

    fig, ax = plt.subplots(len(users), figsize=[5,20])
    for i in range(len(users)):
        user = users[i]
        all = query("SELECT strftime('%Y-%m', m.datetime), COUNT(*) FROM chat_message m WHERE m.author=:user GROUP BY strftime('%Y-%m', m.datetime);", {"user": user})
        ax[i].bar(list(map(lambda x: x[0], all)), list(map(lambda x: x[1], all)))

        ax[i].set(xticks=[1])
        #ax[i].set_axis_off()
        ax[i].set_title(user)

    plt.tight_layout()
    plt.axis('off')
    plt.suptitle("Nachrichtenanzahl")
    plt.savefig("trends.png")

draw()
