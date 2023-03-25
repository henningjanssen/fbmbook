import datetime
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
import numpy as np
import argparse
import sys

import sqlite3

con = sqlite3.connect("data/db.sqlite")
def query(sql: str, params=[]):
    cur = con.cursor()
    res = cur.execute(sql, params)
    return res.fetchall()

def get_users() -> list[str]:
    users = query("SELECT DISTINCT(author) FROM chat_message")
    return list(map(lambda x: x[0], users))

def draw_for_each_user(xdata_query, ydata_query, xtick_step=6) -> None:
    users = get_users()
    dates = query(xdata_query)

    fig, ax = plt.subplots(len(users), figsize=[20,len(users)*1.2])
    for i in range(len(users)):
        user = users[i]
        all = dict(query(ydata_query, {"user": user}))
        ax[i].fill_between(list(map(lambda x: x[0], dates)), np.zeros(len(dates)), list(map(lambda x: all.get(x[0]) or 0, dates)), alpha=0.5)

        ax[i].set(xticks=np.arange(len(dates), step=xtick_step))
        ax[i].set_title(user)

    plt.tight_layout()
    #plt.axis('off')
    plt.suptitle("Nachrichtenanzahl")

def draw_for_all(xdata_query, ydata_query, xtick_step=6) -> None:
    dates = query(xdata_query)

    fig, ax = plt.subplots(1, figsize=[20,10])
    all = dict(query(ydata_query))
    ax.fill_between(list(map(lambda x: x[0], dates)), np.zeros(len(dates)), list(map(lambda x: all.get(x[0]) or 0, dates)), alpha=0.5)

    ax.set(xticks=np.arange(len(dates), step=xtick_step))

    plt.tight_layout()
    #plt.axis('off')
    plt.suptitle("Nachrichtenanzahl")


def main() -> int:
    parser = argparse.ArgumentParser(
                        prog = 'Plot Creator',
                        description = 'Creates plots for facebook messenger data')
    parser.add_argument('output_filename')
    parser.add_argument('-e', '--everyone', action='store_true')
    parser.add_argument('-t', '--type', choices=['all-months', 'per-day'])
    args = parser.parse_args()

    if (args.type == 'per-day'):
        xtick_step=30
        xdata_query = "SELECT DISTINCT(strftime('%m-%d', m.datetime)) FROM chat_message m ORDER BY strftime('%m-%d', m.datetime)"
        if (args.everyone):
            ydata_query = "SELECT strftime('%m-%d', m.datetime), COUNT(*) FROM chat_message m GROUP BY strftime('%m-%d', m.datetime);"
        else:
            ydata_query = "SELECT strftime('%m-%d', m.datetime), COUNT(*) FROM chat_message m WHERE m.author=:user GROUP BY strftime('%m-%d', m.datetime);"
    else:
        xdata_query = "SELECT DISTINCT(strftime('%Y-%m', m.datetime)) FROM chat_message m ORDER BY m.datetime"
        xtick_step=6
        if (args.everyone):
            ydata_query = "SELECT strftime('%Y-%m', m.datetime), COUNT(*) FROM chat_message m GROUP BY strftime('%Y-%m', m.datetime);"
        else:
            ydata_query = "SELECT strftime('%Y-%m', m.datetime), COUNT(*) FROM chat_message m WHERE m.author=:user GROUP BY strftime('%Y-%m', m.datetime);"


    if (args.everyone):
        draw_for_all(xdata_query, ydata_query, xtick_step)
    else:
        draw_for_each_user(xdata_query, ydata_query, xtick_step)
    plt.savefig(args.output_filename)

    return 0



if __name__ == '__main__':
    sys.exit(main())  # next section explains the use of sys.exit
